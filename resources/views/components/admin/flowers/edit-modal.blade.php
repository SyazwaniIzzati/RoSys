<div
    class="modal fade rosys-modal"
    id="editFlowerModal{{ $flower->flower_id }}"
    tabindex="-1"
    aria-labelledby="editFlowerModalLabel{{ $flower->flower_id }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5
                    class="modal-title"
                    id="editFlowerModalLabel{{ $flower->flower_id }}"
                >
                    Edit {{ $flower->flower_name }}
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>

            <form
                action="{{ route('admin.flowers.update', $flower->flower_id) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                <input
                    type="hidden"
                    name="category_id"
                    value="{{ old('category_id', $category->category_id) }}"
                >

                <div class="modal-body">

                    {{-- Flower Name --}}
                    <div class="mb-3">
                        <label
                            for="flower_name_{{ $flower->flower_id }}"
                            class="form-label"
                        >
                            Flower Name
                        </label>

                        <input
                            type="text"
                            id="flower_name_{{ $flower->flower_id }}"
                            name="flower_name"
                            class="form-control"
                            value="{{ old('flower_name', $flower->flower_name) }}"
                            required
                        >
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label
                            for="description_{{ $flower->flower_id }}"
                            class="form-label"
                        >
                            Description
                        </label>

                        <textarea
                            id="description_{{ $flower->flower_id }}"
                            name="description"
                            class="form-control"
                            rows="4"
                            required
                        >{{ old('description', $flower->description) }}</textarea>
                    </div>

                    {{-- Price Per Stem --}}
                    <div class="mb-3">
                        <label
                            for="price_per_stem_{{ $flower->flower_id }}"
                            class="form-label"
                        >
                            Price Per Stem (RM)
                        </label>

                        <input
                            type="number"
                            id="price_per_stem_{{ $flower->flower_id }}"
                            name="price_per_stem"
                            class="form-control"
                            step="0.01"
                            min="0"
                            value="{{ old('price_per_stem', $flower->price_per_stem) }}"
                        >
                    </div>

                    {{-- Price Per Bunch --}}
                    <div class="mb-3">
                        <label
                            for="price_per_bunch_{{ $flower->flower_id }}"
                            class="form-label"
                        >
                            Price Per Bunch (RM)
                        </label>

                        <input
                            type="number"
                            id="price_per_bunch_{{ $flower->flower_id }}"
                            name="price_per_bunch"
                            class="form-control"
                            step="0.01"
                            min="0"
                            value="{{ old('price_per_bunch', $flower->price_per_bunch) }}"
                        >
                    </div>

                    {{-- Stock Quantity --}}
                    <div class="mb-3">
                        <label
                            for="stock_quantity_{{ $flower->flower_id }}"
                            class="form-label"
                        >
                            Stock Quantity
                        </label>

                        <input
                            type="number"
                            id="stock_quantity_{{ $flower->flower_id }}"
                            name="stock_quantity"
                            class="form-control"
                            min="0"
                            value="{{ old('stock_quantity', $flower->stock_quantity) }}"
                            required
                        >
                    </div>

                    {{-- Minimum Order Bunch Quantity --}}
                    <div class="mb-3">
                        <label
                            for="bunch_quantity_{{ $flower->flower_id }}"
                            class="form-label"
                        >
                            Minimum Order Bunch Quantity
                        </label>

                        <input
                            type="number"
                            id="bunch_quantity_{{ $flower->flower_id }}"
                            name="bunch_quantity"
                            class="form-control"
                            min="1"
                            value="{{ old('bunch_quantity', $flower->bunch_quantity) }}"
                            required
                        >
                    </div>

                    {{-- Availability --}}
                    <div class="mb-3">
                        <label
                            for="availability_{{ $flower->flower_id }}"
                            class="form-label"
                        >
                            Availability
                        </label>

                        <select
                            id="availability_{{ $flower->flower_id }}"
                            name="availability"
                            class="form-control"
                            required
                        >
                            <option
                                value="1"
                                @selected((string) old('availability', $flower->availability) === '1')
                            >
                                Available
                            </option>

                            <option
                                value="0"
                                @selected((string) old('availability', $flower->availability) === '0')
                            >
                                Unavailable
                            </option>
                        </select>
                    </div>

                    {{-- Current Image --}}
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>

                        @if ($flower->image)
                            <div>
                                <img
                                    src="{{ asset('storage/' . $flower->image) }}"
                                    alt="{{ $flower->flower_name }}"
                                    style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px;"
                                >
                            </div>
                        @else
                            <p class="text-muted">No image uploaded.</p>
                        @endif
                    </div>

                    {{-- New Image --}}
                    <div class="mb-3">
                        <label
                            for="image_{{ $flower->flower_id }}"
                            class="form-label"
                        >
                            Change Image
                        </label>

                        <input
                            type="file"
                            id="image_{{ $flower->flower_id }}"
                            name="image"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        >

                        <small class="text-muted">
                            Leave empty to keep the current image. Maximum 2MB.
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