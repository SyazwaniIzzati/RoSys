<div class="modal fade rosys-modal"
    id="editCategoryModal{{ $category->category_id }}"
    tabindex="-1"
    aria-labelledby="editCategoryModalLabel{{ $category->category_id }}"
    aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title"
                    id="editCategoryModalLabel{{ $category->category_id }}">
                    Edit Category
                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            {{-- IMPORTANT: required for image upload --}}
            <form
                action="{{ route('admin.categories.update', $category->category_id) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="modal-body">

                    {{-- Category Name --}}
                    <div class="mb-3">
                        <label
                            for="category_name_{{ $category->category_id }}"
                            class="form-label">
                            Category Name
                        </label>

                        <input
                            type="text"
                            name="category_name"
                            id="category_name_{{ $category->category_id }}"
                            class="form-control"
                            value="{{ $category->category_name }}"
                            required
                        >

                        @error('category_name')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label
                            for="description_{{ $category->category_id }}"
                            class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            id="description_{{ $category->category_id }}"
                            class="form-control"
                            rows="4">{{ $category->description }}</textarea>

                        @error('description')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Current Image --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Current Image
                        </label>

                        @if ($category->image)
                            <div class="mb-2">
                                <img
                                    src="{{ asset('storage/' . $category->image) }}"
                                    alt="{{ $category->category_name }}"
                                    style="
                                        width: 100px;
                                        height: 100px;
                                        object-fit: cover;
                                        border-radius: 8px;
                                    "
                                >
                            </div>
                        @else
                            <p class="text-muted">
                                No image uploaded.
                            </p>
                        @endif
                    </div>

                    {{-- New Image --}}
                    <div class="mb-3">
                        <label
                            for="image_{{ $category->category_id }}"
                            class="form-label">
                            Change Image
                        </label>

                        <input
                            type="file"
                            name="image"
                            id="image_{{ $category->category_id }}"
                            class="form-control"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                        >

                        <small class="text-muted">
                            Leave empty to keep the current image.
                            Accepted formats: JPG, JPEG, PNG, WEBP. Maximum size: 2MB.
                        </small>

                        @error('image')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                        class="rosys-modal-btn rosys-modal-btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                        class="rosys-modal-btn rosys-modal-btn-primary">
                        Save Changes
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>