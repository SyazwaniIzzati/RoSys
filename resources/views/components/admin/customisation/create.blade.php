<div
    class="modal fade rosys-modal"
    id="createCustomisationModal"
    tabindex="-1"
    aria-labelledby="createCustomisationModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="createCustomisationModalLabel">
                    Add {{ ucwords(str_replace('_', ' ', $optionType)) }}
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <form
                action="{{ route('admin.customisation.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <input
                    type="hidden"
                    name="option_type"
                    value="{{ $optionType }}"
                >

                <div class="modal-body">

                    {{-- Option Name --}}
                    <div class="mb-3">
                        <label for="createOptionName" class="form-label">
                            Name
                        </label>

                        <input
                            type="text"
                            id="createOptionName"
                            name="option_name"
                            class="form-control"
                            value="{{ old('option_name') }}"
                            placeholder="Enter customisation name"
                            required
                        >
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label for="createOptionDescription" class="form-label">
                            Description
                        </label>

                        <textarea
                            id="createOptionDescription"
                            name="description"
                            class="form-control"
                            rows="3"
                            placeholder="Enter description"
                        >{{ old('description') }}</textarea>
                    </div>

                    {{-- Price --}}
                    <div class="mb-3">
                        <label for="createOptionPrice" class="form-label">
                            Additional Price (RM)
                        </label>

                        <input
                            type="number"
                            id="createOptionPrice"
                            name="price"
                            class="form-control"
                            value="{{ old('price', '0.00') }}"
                            min="0"
                            step="0.01"
                            required
                        >
                    </div>

                    {{-- Stock: Wrapping and Ribbon only --}}
                    @if (in_array($optionType, ['wrapping', 'ribbon']))
                        <div class="mb-3">
                            <label for="createOptionStock" class="form-label">
                                Stock Quantity
                            </label>

                            <input
                                type="number"
                                id="createOptionStock"
                                name="stock_quantity"
                                class="form-control"
                                value="{{ old('stock_quantity', 0) }}"
                                min="0"
                                required
                            >

                            <small class="text-muted">
                                Availability will be determined by the stock quantity.
                            </small>
                        </div>
                    @else
                        <input
                            type="hidden"
                            name="stock_quantity"
                            value="0"
                        >

                        <div class="mb-3">
                            <label for="createOptionAvailability" class="form-label">
                                Availability
                            </label>

                            <select
                                id="createOptionAvailability"
                                name="availability"
                                class="form-control"
                                required
                            >
                                <option value="1"
                                    {{ old('availability', '1') == '1' ? 'selected' : '' }}>
                                    Available
                                </option>

                                <option value="0"
                                    {{ old('availability') === '0' ? 'selected' : '' }}>
                                    Unavailable
                                </option>
                            </select>
                        </div>
                    @endif

                    {{-- Image --}}
                    <div class="mb-3">
                        <label for="createOptionImage" class="form-label">
                            Image
                        </label>

                        <input
                            type="file"
                            id="createOptionImage"
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
                        Save Customisation
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
```
