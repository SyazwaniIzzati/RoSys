<div
    class="modal fade rosys-modal"
    id="createFlowerModal"
    tabindex="-1"
    aria-labelledby="createFlowerModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="createFlowerModalLabel"
                >
                    Add {{ $category->category_name }}
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
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
                    value="{{ old('category_id', $category->category_id) }}"
                >

                <div class="modal-body">

                    {{-- Flower Name --}}
                    <div class="mb-3">
                        <label
                            for="create_flower_name"
                            class="form-label"
                        >
                            Flower Name
                        </label>

                        <input
                            type="text"
                            id="create_flower_name"
                            name="flower_name"
                            class="form-control"
                            placeholder="e.g. Pink Rose"
                            value="{{ old('flower_name') }}"
                            required
                        >
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label
                            for="create_description"
                            class="form-label"
                        >
                            Description
                        </label>

                        <textarea
                            id="create_description"
                            name="description"
                            class="form-control"
                            rows="4"
                            placeholder="Enter flower description"
                            required
                        >{{ old('description') }}</textarea>
                    </div>

                    {{-- Price Per Stem --}}
                    <div class="mb-3">
                        <label
                            for="create_price_per_stem"
                            class="form-label"
                        >
                            Price Per Stem (RM)
                        </label>

                        <input
                            type="number"
                            id="create_price_per_stem"
                            name="price_per_stem"
                            class="form-control"
                            step="0.01"
                            min="0"
                            placeholder="e.g. 5.00"
                            value="{{ old('price_per_stem') }}"
                        >
                    </div>

                    {{-- Price Per Bunch --}}
                    <div class="mb-3">
                        <label
                            for="create_price_per_bunch"
                            class="form-label"
                        >
                            Price Per Bunch (RM)
                        </label>

                        <input
                            type="number"
                            id="create_price_per_bunch"
                            name="price_per_bunch"
                            class="form-control"
                            step="0.01"
                            min="0"
                            placeholder="e.g. 45.00"
                            value="{{ old('price_per_bunch') }}"
                        >
                    </div>

                    {{-- Stock Quantity --}}
                    <div class="mb-3">
                        <label
                            for="create_stock_quantity"
                            class="form-label"
                        >
                            Stock Quantity
                        </label>

                        <input
                            type="number"
                            id="create_stock_quantity"
                            name="stock_quantity"
                            class="form-control"
                            min="0"
                            value="{{ old('stock_quantity', 0) }}"
                            required
                        >
                    </div>

                    {{-- Minimum Order Bunch Quantity --}}
                    <div class="mb-3">
                        <label
                            for="create_bunch_quantity"
                            class="form-label"
                        >
                            Minimum Order Bunch Quantity
                        </label>

                        <input
                            type="number"
                            id="create_bunch_quantity"
                            name="bunch_quantity"
                            class="form-control"
                            min="1"
                            value="{{ old('bunch_quantity', 1) }}"
                            required
                        >
                    </div>

                    {{-- Availability --}}
                    <div class="mb-3">
                        <label
                            for="create_availability"
                            class="form-label"
                        >
                            Availability
                        </label>

                        <select
                            id="create_availability"
                            name="availability"
                            class="form-control"
                            required
                        >
                            <option
                                value="1"
                                @selected((string) old('availability', '1') === '1')
                            >
                                Available
                            </option>

                            <option
                                value="0"
                                @selected((string) old('availability', '1') === '0')
                            >
                                Unavailable
                            </option>
                        </select>
                    </div>

                    {{-- Flower Image --}}
                    <div class="mb-3">
                        <label
                            for="create_image"
                            class="form-label"
                        >
                            Flower Image
                        </label>

                        <input
                            type="file"
                            id="create_image"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
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