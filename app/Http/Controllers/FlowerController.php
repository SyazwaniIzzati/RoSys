<?php

namespace App\Http\Controllers;

use App\Models\Flowers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FlowerController extends Controller
{
    public function index()
    {
        $flowers = Flowers::with('category')
            ->orderBy('flower_name')
            ->get();

        $categories = Category::orderBy('category_name')->get();

        return view('admin.flowers.index', compact('flowers', 'categories'));
    }

    public function category($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $flowers = Flowers::where('category_id', $categoryId)
            ->orderBy('flower_name')
            ->get();

        return view(
            'admin.flowers.category',
            compact('category', 'flowers')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'flower_name' => 'required|string | max:255',
            'description' => 'required|string',
            'price_per_stem' => 'nullable|numeric|min:0',
            'price_per_bunch' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_order_quantity' => 'required|integer|min:1',
            'availability' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('flowers', 'public');
        }

        Flowers::create($validated);

        return redirect()
            ->route('admin.flowers')
            ->with('success', 'Flower added successfully');
    }

    public function update(Request $request, Flowers $flower)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,category_id',
            'flower_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_stem' => 'nullable|numeric|min:0',
            'price_per_bunch' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_order_quantity' => 'required|integer|min:1',
            'availability' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {

            if ($flower->image) {
                Storage::disk('public')->delete($flower->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('flowers', 'public');
        }

        $flower->update($validated);

        return redirect()
            ->route('admin.flowers')
            ->with('success', 'Flower updated successfully.');
    }

    public function destroy(Flowers $flower)
    {
        if ($flower->image) {
            Storage::disk('public')->delete($flower->image);
        }

        $flower->delete();

        return redirect()
            ->route('admin.flowers')
            ->with('success', 'Flower deleted successfully.');
    }
}
