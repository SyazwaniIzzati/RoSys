<?php

namespace App\Http\Controllers;

use App\Models\CustomisationOption;
use App\Models\Category;
use App\Models\Flowers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CustomisationOptionController extends Controller
{
    /**
     * Allowed customisation types.
     */
    private const OPTION_TYPES = [
        'wrapping',
        'ribbon',
        'theme_colour',
        'bouquet_style',
    ];

    /**
     * Display the main admin customisation page.
     */
    public function index()
    {
        return view('admin.customisation.index');
    }

    /**
     * Display customisation options for a selected type.
     */
    public function type(string $optionType)
    {
        abort_unless(
            in_array($optionType, self::OPTION_TYPES, true),
            404
        );

        $options = CustomisationOption::where(
            'option_type',
            $optionType
        )->latest()->get();

        return view('admin.customisation.type', compact(
            'options',
            'optionType'
        ));
    }

    /**
     * Store a new customisation option.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'option_name' => 'required|string|max:255',
            'option_type' => [
                'required',
                Rule::in(self::OPTION_TYPES),
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'availability' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('customisation-options', 'public');
        }

        $validated['availability'] = $this->isAvailable(
            $validated['option_type'],
            (int) $validated['stock_quantity'],
            $request->boolean('availability')
        );

        CustomisationOption::create($validated);

        return redirect()
            ->route(
                'admin.customisation.type',
                $validated['option_type']
            )
            ->with('success', 'Customisation option added successfully.');
    }

    /**
     * Update an existing customisation option.
     */
    public function update(
        Request $request,
        CustomisationOption $customisationOption
    ) {
        $validated = $request->validate([
            'option_name' => 'required|string|max:255',
            'option_type' => [
                'required',
                Rule::in(self::OPTION_TYPES),
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'availability' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $newImage = $request->file('image')
                ->store('customisation-options', 'public');

            if ($customisationOption->image) {
                Storage::disk('public')->delete(
                    $customisationOption->image
                );
            }

            $validated['image'] = $newImage;
        }

        $validated['availability'] = $this->isAvailable(
            $validated['option_type'],
            (int) $validated['stock_quantity'],
            $request->boolean('availability')
        );

        $customisationOption->update($validated);

        return redirect()
            ->route(
                'admin.customisation.type',
                $validated['option_type']
            )
            ->with('success', 'Customisation option updated successfully.');
    }

    /**
     * Determine availability based on option type.
     */
    private function isAvailable(
        string $optionType,
        int $stockQuantity,
        bool $requestedAvailability
    ): bool {
        // These options do not require physical stock.
        if (in_array($optionType, [
            'theme_colour',
            'bouquet_style',
        ], true)) {
            return $requestedAvailability;
        }

        // Wrapping and ribbon require available stock.
        return $stockQuantity > 0;
    }

    /**
     * Delete a customisation option.
     */
    public function destroy(CustomisationOption $customisationOption)
    {
        $optionType = $customisationOption->option_type;

        if ($customisationOption->image) {
            Storage::disk('public')->delete(
                $customisationOption->image
            );
        }

        $customisationOption->delete();

        return redirect()
            ->route('admin.customisation.type', $optionType)
            ->with('success', 'Customisation option deleted successfully.');
    }

    /**
     * Display available customisation options for customers.
     */
    public function customerIndex()
    {
        $flowers = Flowers::all();

        // Kategori untuk langkah 1 (pilih kategori dahulu)
        $categories = Category::orderBy('category_name')->get();   // ganti nama model

        $options = CustomisationOption::where('availability', true)
            ->where(function ($query) {
                $query->whereIn('option_type', [
                    'theme_colour',
                    'bouquet_style',
                ])->orWhere(function ($query) {
                    $query->whereIn('option_type', [
                        'wrapping',
                        'ribbon',
                    ])->where('stock_quantity', '>', 0);
                });
            })
            ->orderBy('option_name')
            ->get()
            ->groupBy('option_type');

        return view('customise.index', compact('flowers', 'options', 'categories'));
    }
}
