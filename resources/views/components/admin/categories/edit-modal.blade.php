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

            <form
                action="{{ route('admin.categories.update', $category->category_id) }}"
                method="POST">
            
                @csrf
                @method('PUT')

                <div class="modal-body">

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
                    </div>
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
                            rows="4"
                            >{{ $category->description }}</textarea>
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