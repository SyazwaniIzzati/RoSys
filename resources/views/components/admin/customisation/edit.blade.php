<div
    class="modal fade rosys-modal"
    id="editCustomisationModal{{ $option->option_id }}"
    tabindex="-1"
    aria-labelledby="editCustomisationModalLabel{{ $option->option_id }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="editCustomisationModalLabel{{ $option->option_id }}"
                >
                    Edit {{ ucwords(str_replace('_', ' ', $optionType)) }}
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <form
                action="{{ route('admin.customisation.update', $option->option_id) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                <input
                    type="hidden"
                    name="option_type"
                    value="{{ $optionType }}"
                >

                <div class="modal-body">

                    {{-- Name --}}
                    <div class="mb-3">
                        <label
                            for="editOptionName{{ $option->option_id }}"
                            class="form-label"
                        >
                            Name
                        </label>

                        <input
                            type="text"
                            id="editOptionName{{ $option->option_id }}"
                            name="option_name"
                            class="form-control"
                            value="{{ $option->option_name }}"
                            required
                        >
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label
                            for="editOptionDescription{{ $option->option_id }}"
                            class="form-label"
                        >
                            Description
                        </label>

                        <textarea
                            id="editOptionDescription{{ $option->option_id }}"
                            name="description"
                            class="form-control"
                            rows="3"
                        >{{ $option->description }}</textarea>
                    </div>

                    {{-- Price --}}
                    <div class="mb-3">
                        <label
                            for="editOptionPrice{{ $option->option_id }}"
                            class="form-label"
                        >
                            Additional Price (RM)
                        </label>

                        <input
                            type="number"
                            id="editOptionPrice{{ $option->option_id }}"
                            name="price"
                            class="form-control"
                            value="{{ $option->price }}"
                            min="0"
                            step="0.01"
                            required
                        >
                    </div>

                    {{-- Stock for Wrapping and Ribbon --}}
                    @if (in_array($optionType, ['wrapping', 'ribbon']))
                        <div class="mb-3">
                            <label
                                for="editOptionStock{{ $option->option_id }}"
                                class="form-label"
                            >
                                Stock Quantity
                            </label>

                            <input
                                type="number"
                                id="editOptionStock{{ $option->option_id }}"
                                name="stock_quantity"
                                class="form-control"
                                value="{{ $option->stock_quantity }}"
                                min="0"
                                required
                            >

                            <small class="text-muted">
                                Availability is determined by the stock quantity.
                            </small>
                        </div>
                    @else
                        <input
                            type="hidden"
                            name="stock_quantity"
                            value="0"
                        >

                        <div class="mb-3">
                            <label
                                for="editOptionAvailability{{ $option->option_id }}"
                                class="form-label"
                            >
                                Availability
                            </label>

                            <select
                                id="editOptionAvailability{{ $option->option_id }}"
                                name="availability"
                                class="form-control"
                                required
                            >
                                <option
                                    value="1"
                                    {{ $option->availability ? 'selected' : '' }}
                                >
                                    Available
                                </option>

                                <option
                                    value="0"
                                    {{ !$option->availability ? 'selected' : '' }}
                                >
                                    Unavailable
                                </option>
                            </select>
                        </div>
                    @endif

                    {{-- Current Image --}}
                    @if ($option->image)
                        <div class="mb-3">
                            <label class="form-label">Current Image</label>

                            <div>
                                <img
                                    src="{{ asset('storage/' . $option->image) }}"
                                    alt="{{ $option->option_name }}"
                                    style="width: 120px; height: 120px; object-fit: cover; border-radius: 6px;"
                                >
                            </div>
                        </div>
                    @endif

                    {{-- Replace Image --}}
                    <div class="mb-3">
                        <label
                            for="editOptionImage{{ $option->option_id }}"
                            class="form-label"
                        >
                            {{ $option->image ? 'Replace Image' : 'Upload Image' }}
                        </label>

                        <input
                            type="file"
                            id="editOptionImage{{ $option->option_id }}"
                            name="image"
                            class="form-control"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                        >

                        <small class="text-muted">
                            Leave empty to keep the current image.
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
                        Save Changes
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>