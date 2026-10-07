<x-admin-layout title="{{ $category->category_name }}">

    <div class="flower-category-header">

        <div>
            <a
                href="{{ route('admin.flowers') }}"
                class="back-link"
            >
                ← Back to Flowers
            </a>

            <h1 class="page-title">
                {{ $category->category_name }}
            </h1>

            <p class="page-lead">
                {{ $category->description }}
            </p>
        </div>

        <div>
            <button
                type="button"
                class="pill-btn"
                data-bs-toggle="modal"
                data-bs-target="#createFlowerModal"
            >
                + Add {{ $category->category_name }}
            </button>
        </div>

    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="flower-grid">

        @forelse ($flowers as $flower)

            <div class="flower-card">

                {{-- Flower Image --}}
                @if ($flower->image)

                    <img
                        src="{{ asset('storage/' . $flower->image) }}"
                        alt="{{ $flower->flower_name }}"
                        class="flower-card-image"
                    >

                @else

                    <div class="flower-card-image flower-image-empty">
                        No Image
                    </div>

                @endif

                <div class="flower-card-content">

                    <h3>
                        {{ $flower->flower_name }}
                    </h3>

                    <p class="flower-description">
                        {{ $flower->description }}
                    </p>

                    <div class="flower-prices">

                        @if ($flower->price_per_stem !== null)
                            <div>
                                <small>Per Stem</small>
                                <strong>
                                    RM {{ number_format($flower->price_per_stem, 2) }}
                                </strong>
                            </div>
                        @endif

                        @if ($flower->price_per_bunch !== null)
                            <div>
                                <small>Per Bunch</small>
                                <strong>
                                    RM {{ number_format($flower->price_per_bunch, 2) }}
                                </strong>
                            </div>
                        @endif

                    </div>

                    <div class="flower-stock">

                        <span>
                            Stock: {{ $flower->stock_quantity }}
                        </span>

                        @if ($flower->availability)
                            <span class="flower-status available">
                                Available
                            </span>
                        @else
                            <span class="flower-status unavailable">
                                Unavailable
                            </span>
                        @endif

                    </div>

                    <div class="flower-actions">

                        <button
                            type="button"
                            class="pill-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#editFlowerModal{{ $flower->flower_id }}"
                        >
                            Edit
                        </button>

                        <button
                            type="button"
                            class="pill-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteFlowerModal{{ $flower->flower_id }}"
                        >
                            Delete
                        </button>

                    </div>

                </div>

            </div>

        @empty

            <div class="flower-empty-state">

                <h3>
                    No {{ $category->category_name }} yet
                </h3>

                <p>
                    Add the first flower to this category.
                </p>

            </div>

        @endforelse

    </div>

    {{-- Create Flower Modal --}}
    <x-admin.flowers.create-modal :category="$category" />

    {{-- Edit & Delete Modals --}}
    @foreach ($flowers as $flower)

        <x-admin.flowers.edit-modal
            :flower="$flower"
            :category="$category"
        />

        <x-admin.flowers.delete-modal
            :flower="$flower"
        />

    @endforeach

</x-admin-layout>