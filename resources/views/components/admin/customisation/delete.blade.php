<div
    class="modal fade rosys-modal"
    id="deleteCustomisationModal{{ $option->option_id }}"
    tabindex="-1"
    aria-labelledby="deleteCustomisationModalLabel{{ $option->option_id }}"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">

            {{-- Modal Header --}}
            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="deleteCustomisationModalLabel{{ $option->option_id }}"
                >
                    Delete Customisation
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body">
                <p>
                    Are you sure you want to delete
                    <strong>{{ $option->option_name }}</strong>?
                </p>

                <p class="text-muted mb-0">
                    This action cannot be undone.
                </p>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer">
                <button
                    type="button"
                    class="rosys-modal-btn rosys-modal-btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <form
                    action="{{ route('admin.customisation.destroy', $option->option_id) }}"
                    method="POST"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="rosys-modal-btn rosys-modal-btn-primary"
                    >
                        Delete Customisation
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>