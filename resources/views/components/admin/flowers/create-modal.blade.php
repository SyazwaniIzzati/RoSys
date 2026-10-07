<div class="modal fade rosys-modal"
    id="createFlowerModal"
    tabindex="-1"
    aria-labelledby="createFlowerModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="createFlowerModalLabel">
                    Add {{ $category->category_name }}
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <form
                action="{{ route('admin.flowers.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                <input
                    type="hidden"
                    name="category_id"
                    value="{{ $category->category_id }}"
                >

                <div class="modal-body">

                    {{-- Flower Name --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Flower Name
                        </label>

                        <input
                            type="text"
                            name="flower_name"
                            class="form-control"
                            placeholder="e.g. Pink Rose"
                            value="{{ old('flower_name') }}"
                            required
                        >

                    </div>

                    {{-- Description --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="4"
                            placeholder="Enter flower description"
                            required
                        >{{ old('description') }}</textarea>

                    </div>

                    {{-- Price Per Stem --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Price Per Stem (RM)
                        </label>

                        <input
                            type="number"
                            name="price_per_stem"
                            class="form-control"
                            step="0.01"
                            min="0"
                            placeholder="e.g. 5.00"
                        >

                    </div>

                    {{-- Price Per Bunch --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Price Per Bunch (RM)
                        </label>

                        <input
                            type="number"
                            name="price_per_bunch"
                            class="form-control"
                            step="0.01"
                            min="0"
                            placeholder="e.g. 45.00"
                        >

                    </div>

                    {{-- Stock --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Stock Quantity
                        </label>

                        <input
                            type="number"
                            name="stock_quantity"
                            class="form-control"
                            min="0"
                            value="0"
                            required
                        >

                    </div>

                    {{-- Minimum Order --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Minimum Order Bunch Quantity
                        </label>

                        <input
                            type="number"
                            name="bunch_quantity"
                            class="form-control"
                            min="1"
                            value="1"
                            required
                        >

                    </div>

                    {{-- Availability --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Availability
                        </label>

                        <select
                            name="availability"
                            class="form-control"
                            required
                        >
                            <option value="1">Available</option>
                            <option value="0">Unavailable</option>
                        </select>

                    </div>

                    {{-- Image --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Flower Image
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                        >

                        <small class="text-muted">
                            JPG, JPEG, PNG or WEBP. Maximum 2MB.
                        </small>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="rosys-modal-btn rosys-modal-btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="rosys-modal-btn rosys-modal-btn-primary"
                    >
                        Save Flower
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>