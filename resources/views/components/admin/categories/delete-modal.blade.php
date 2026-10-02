<div class="modal fade rosys-modal"
    id="deleteCategoryModal{{ $category->category_id }}"
    tabindex="-1"
    aria-labelledby="deleteCategoryModalLabel{{ $category->category_id }}"
    aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title"
                id="deleteCategoryModalLabel{{ $category->category_id }}">
                Delete Category          
            </h5>

            <button type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="close">
            </button>
            </div>

            <div class="modal-body">
                <p>
                    Are you sure you want to delete 
                    <strong>{{ $category->category_name }}</strong>
                </p>

                <p class="text-muted">
                    This action cannot be undone.
                </p>
            </div>

            <div class="modal-footer">

                <button type="button"
                    class="rosys-modal-btn rosys-modal-btn-secondary"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <form
                    action="{{ route('admin.categories.destroy', $category->category_id) }}"
                    method="POST">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="rosys-modal-btn rosys-modal-btn-primay">
                        Delete Category
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>