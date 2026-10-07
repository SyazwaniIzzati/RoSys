<div class="modal fade rosys-modal"
    id="deleteFlowerModal{{ $flower->flower_id }}"
    tabindex="-1"
    aria-labelledby="deleteFlowerModalLabel{{ $flower->flower_id }}"
    aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title"
                    id="deleteFlowerModalLabel{{ $flower->flower_id }}">
                    Delete Flower
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <div class="modal-body">

                <p>
                    Are you sure you want to delete
                    <strong>{{ $flower->flower_name }}</strong>?
                </p>

                <p class="text-muted">
                    This action cannot be undone.
                </p>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="rosys-modal-btn rosys-modal-btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <form
                    action="{{ route('admin.flowers.destroy', $flower->flower_id) }}"
                    method="POST"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="rosys-modal-btn rosys-modal-btn-primary"
                    >
                        Delete Flower
                    </button>

                </form>

            </div>

        </div>
    </div>
</div>