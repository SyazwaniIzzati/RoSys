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
            'bunch_quantity' => 'required|integer|min:5',
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
            ->route('admin.flowers.category', ['categoryId' => $validated['category_id']])
            ->with('success');
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
            'bunch_quantity' => 'required|integer|min:5',
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
            ->route('admin.flowers.category', ['categoryId' => $validated['category_id']])
            ->with('success', 'Flower updated successfully.');
    }

    public function destroy(Flowers $flower)
    {
        if ($flower->image) {
            Storage::disk('public')->delete($flower->image);
        }

        $flower->delete();

        return redirect()
            ->route('admin.flowers.category')
            ->with('success', 'Flower deleted successfully.');
    }

    // Customer: display all flowers
    public function customerIndex(Request $request)
    {
        $categories = Category::orderBy('category_name')->get();

        $flowers = Flowers::with('category');

        $sort = $request->query('sort', 'latest');

        switch ($sort) {
            case 'price_low':
                $flowers->orderBy('price_per_stem', 'asc');
                break;

            case 'price_high':
                $flowers->orderBy('price_per_stem', 'desc');
                break;

            case 'name':
                $flowers->orderBy('flower_name', 'asc');
                break;

            default:
                $sort = 'latest';
                $flowers->orderByDesc('created_at');
                break;
        }

        // Pagination: display 10 flowers per page
        $flowers = $flowers->paginate(10)->withQueryString();

        $activeCategory = null;

        return view('flowers.index', compact(
            'flowers',
            'categories',
            'activeCategory',
            'sort'
        ));
    }


    // Customer: display flowers in a selected category
    public function customerCategory(Request $request, $categoryId)
    {
        $activeCategory = Category::findOrFail($categoryId);

        $categories = Category::orderBy('category_name')->get();

        $flowers = Flowers::with('category')
            ->where('category_id', $categoryId);

        $sort = $request->query('sort', 'latest');

        switch ($sort) {
            case 'price_low':
                $flowers->orderBy('price_per_stem', 'asc');
                break;

            case 'price_high':
                $flowers->orderBy('price_per_stem', 'desc');
                break;

            case 'name':
                $flowers->orderBy('flower_name', 'asc');
                break;

            default:
                $sort = 'latest';
                $flowers->orderByDesc('created_at');
                break;
        }

        // Pagination: display 10 flowers per page
        $flowers = $flowers->paginate(10)->withQueryString();

        return view('flowers.index', compact(
            'flowers',
            'categories',
            'activeCategory',
            'sort'
        ));
    }
}
