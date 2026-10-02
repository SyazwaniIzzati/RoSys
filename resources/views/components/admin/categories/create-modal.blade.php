<div class="modal fade rosys-modal" id="createCategoryModal" tabindex="-1"
    aria-labelledby="createCategoryModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCategoryModalLabel">
                    Add Category
                </h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST">

                @csrf

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category_name" class="form-label">
                            Category Name
                        </label>

                        <input
                            type="text"
                            name="category_name"
                            id="category_name"
                            class="form-control"
                            placeholder="e.g Bunch" value="{{ old('category_name') }}"
                            required>

                        @error('category_name')
                        <div class="text-danger mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            id="description"
                            class="form-control"
                            rows="4"
                            placeholder="Enter category description">{{ old('description') }}</textarea>

                        @error('description')
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
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>