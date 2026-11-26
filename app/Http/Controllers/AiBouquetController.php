<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class AiBouquetController extends Controller
{
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'prompt' => ['required', 'string', 'max:500'],
        ]);

        $accountId = config('services.cloudflare.account_id');
        $apiToken = config('services.cloudflare.api_token');

        if (!$accountId || !$apiToken) {
            return response()->json([
                'message' => 'AI service configuration is missing.',
            ], 500);
        }

        $prompt = trim($validated['prompt'])
            . '. Realistic florist product photography, a complete '
            . 'hand-tied bouquet, centered composition, plain neutral '
            . 'background, no text, no watermark.';

        $generatedPaths = [];

        try {
            for ($i = 0; $i < 3; $i++) {
                $response = Http::timeout(180)
                    ->withToken($apiToken)
                    ->post(
                        "https://api.cloudflare.com/client/v4/accounts/{$accountId}/ai/run/@cf/black-forest-labs/flux-1-schnell",
                        [
                            'prompt' => $prompt,
                            'steps' => 4,
                        ]
                    );

                if (!$response->successful()) {
                    Log::warning('Cloudflare bouquet generation failed.', [
                        'status' => $response->status(),
                        'response' => mb_substr($response->body(), 0, 2000),
                    ]);

                    foreach ($generatedPaths as $path) {
                        Storage::disk('public')->delete($path);
                    }

                    if ($response->status() === 429) {
                        return response()->json([
                            'message' => 'The AI service is busy or its usage limit has been reached. Please try again later.',
                        ], 429);
                    }

                    return response()->json([
                        'message' => 'Unable to generate the bouquet images. Please try again later.',
                    ], 502);
                }

                $image = $response->json('result.image');
                $imageData = is_string($image)
                    ? base64_decode($image, true)
                    : false;

                if ($imageData === false) {
                    foreach ($generatedPaths as $path) {
                        Storage::disk('public')->delete($path);
                    }

                    return response()->json([
                        'message' => 'The AI service did not return a valid image. Please try again.',
                    ], 502);
                }

                $path = 'bouquet-ai/' . Str::uuid() . '.jpg';

                Storage::disk('public')->put($path, $imageData);

                $generatedPaths[] = $path;
            }

            $images = array_map(function ($path) {
                return [
                    'url' => asset('storage/' . $path),
                ];
            }, $generatedPaths);

            return response()->json([
                'images' => $images,
            ]);
        } catch (Throwable $e) {
            Log::error('AI bouquet generation error.', [
                'error' => $e->getMessage(),
            ]);

            foreach ($generatedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'message' => 'An error occurred while generating images. Please try again.',
            ], 500);
        }
    }
}
