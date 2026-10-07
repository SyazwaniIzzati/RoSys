<div class="modal fade rosys-modal"
    id="editFlowerModal{{ $flower->flower_id }}"
    tabindex="-1"
    aria-labelledby="editFlowerModalLabel{{ $flower->flower_id }}"
    aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title"
                    id="editFlowerModalLabel{{ $flower->flower_id }}">
                    Edit {{ $flower->flower_name }}
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <form
                action="{{ route('admin.flowers.update', $flower->flower_id) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <input
                    type="hidden"
                    name="category_id"
                    value="{{ $category->category_id }}">
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
                            value="{{ $flower->flower_name }}"
                            required>

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
                            required>{{ $flower->description }}</textarea>

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
                            value="{{ $flower->price_per_stem }}">

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
                            value="{{ $flower->price_per_bunch }}">

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
                            value="{{ $flower->stock_quantity }}"
                            required>

                    </div>

                    {{-- Minimum Order --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Minimum Order Quantity
                        </label>

                        <input
                            type="number"
                            name="minimum_order_quantity"
                            class="form-control"
                            min="1"
                            value="{{ $flower->minimum_order_quantity }}"
                            required>

                    </div>

                    {{-- Availability --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Availability
                        </label>

                        <select
                            name="availability"
                            class="form-control"
                            required>
                            <option value="1"
                                {{ $flower->availability ? 'selected' : '' }}>
                                Available
                            </option>

                            <option value="0"
                                {{ !$flower->availability ? 'selected' : '' }}>
                                Unavailable
                            </option>
                        </select>

                    </div>

                    {{-- Current Image --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Current Image
                        </label>

                        @if ($flower->image)

                        <div>
                            <img
                                src="{{ asset('storage/' . $flower->image) }}"
                                alt="{{ $flower->flower_name }}"
                                style="
                                        width: 120px;
                                        height: 120px;
                                        object-fit: cover;
                                        border-radius: 8px;
                                    ">
                        </div>

                        @else

                        <p class="text-muted">
                            No image uploaded.
                        </p>

                        @endif

                    </div>

                    {{-- New Image --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Change Image
                        </label>

                        <input
                            type="file"
                            name="image"
                            class="form-control"
                            accept="image/jpeg,image/png,image/jpg,image/webp">

                        <small class="text-muted">
                            Leave empty to keep the current image.
                            Maximum 2MB.
                        </small>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="rosys-modal-btn rosys-modal-btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="rosys-modal-btn rosys-modal-btn-primary">
                        Save Changes
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>