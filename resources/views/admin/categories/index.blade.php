<x-admin-layout title="Categories">

    <span class="eyebrow">RoSys . Administrator</span>

    <h1 class="page-title">Categories</h1>

    <p class="page-lead">
        Manage the categories to organize your flower collection.
    </p>

    <div class="category-header">
        <button
            type="button"
            class="pill-btn"
            data-bs-toggle="modal"
            data-bs-target="#createCategoryModal">
            + Add Category
        </button>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        Please check the form for errors.
    </div>
    @endif

    <div class="category-table-wrapper">
        <table class="category-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $category->description ?: '_' }}</td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <button
                                type="button"
                                class="pill-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#editCategoryModal{{ $category->category_id }}">
                                Edit
                            </button>

                            <button
                                type="button"
                                class="pill-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteCategoryModal{{ $category->category_id }}">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding:32px;">
                        No categories found. Add your first category.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @foreach ($categories as $category)
    <x-admin.categories.delete-modal :category="$category"/>
    <x-admin.categories.edit-modal :category="$category"/>
    @endforeach
    <x-admin.categories.create-modal />
</x-admin-layout>