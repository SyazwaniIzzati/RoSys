<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // Display admin category list
    public function index()
    {
        $categories = Category::orderBy('category_name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    // Display categories for customer
    public function customerIndex()
    {
        $categories = Category::orderBy('category_name')->get();

        return view('dashboard', compact('categories'));
    }

    // Store new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload category image
        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()
            ->route('admin.categories')
            ->with('success', 'Category created successfully.');
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Upload new category image
        if ($request->hasFile('image')) {

            // Delete old image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()
            ->route('admin.categories')
            ->with('success', 'Category updated successfully.');
    }

    // Delete category
    public function destroy(Category $category)
    {
        // Delete category image
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()
            ->route('admin.categories')
            ->with('success', 'Category deleted successfully.');
    }
}