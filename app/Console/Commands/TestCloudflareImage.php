<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TestCloudflareImage extends Command
{
    protected $signature = 'cloudflare:test-image';

    protected $description = 'Test Cloudflare AI bouquet image generation';

    public function handle(): int
    {
        $accountId = config('services.cloudflare.account_id');
        $apiToken = config('services.cloudflare.api_token');

        if (!$accountId || !$apiToken) {
            $this->error('Cloudflare configuration is missing.');
            return self::FAILURE;
        }

        $this->info('Generating one test bouquet image...');

        try {
            $response = Http::timeout(180)
                ->withToken($apiToken)
                ->post(
                    "https://api.cloudflare.com/client/v4/accounts/{$accountId}/ai/run/@cf/black-forest-labs/flux-1-schnell",
                    [
                        'prompt' => 'A realistic hand-tied bouquet of pink roses and white tulips, elegant beige wrapping paper, professional florist product photography, centered composition, plain light background, no text.',
                        'steps' => 4,
                    ]
                );

            if (!$response->successful()) {
                $this->error(
                    'Cloudflare request failed. HTTP status: '
                    . $response->status()
                );

                $this->line(
                    'Response: ' . $response->body()
                );

                return self::FAILURE;
            }

            $image = $response->json('result.image');

            if (!$image) {
                $this->error('No image was returned by Cloudflare.');
                $this->line($response->body());

                return self::FAILURE;
            }

            $imageData = base64_decode($image, true);

            if ($imageData === false) {
                $this->error('Could not decode the generated image.');
                return self::FAILURE;
            }

            $path = 'bouquet-previews/ai-test.jpg';

            Storage::disk('public')->put($path, $imageData);

            $this->info('AI image generated successfully!');
            $this->info('Saved to: storage/app/public/' . $path);
            $this->info('Open: public/storage/' . $path);

            return self::SUCCESS;

        } catch (\Throwable $e) {
            report($e);

            $this->error(
                'The request could not be completed. Check the Laravel log for details.'
            );

            return self::FAILURE;
        }
    }
}
