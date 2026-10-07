<x-admin-layout title="Flowers">

    <span class="eyebrow">RoSys . Administrator</span>

    <h1 class="page-title">Flowers</h1>

    <p class="page-lead">
        Manage your flower collection by category.
    </p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="flower-category-cards">

        @forelse ($categories as $category)

            <a
                href="{{ route('admin.flowers.category', $category->category_id) }}"
                class="flower-category-card"
            >

                {{-- Category Image --}}
                @if ($category->image)
                    <img
                        src="{{ asset('storage/' . $category->image) }}"
                        alt="{{ $category->category_name }}"
                        class="flower-category-image"
                    >
                @else
                    <div class="flower-category-image flower-category-image-empty">
                        No Image
                    </div>
                @endif

                <div class="flower-category-content">

                    <h2>
                        {{ $category->category_name }}
                    </h2>

                    <p>
                        {{ $category->description ?: 'Explore this flower category.' }}
                    </p>

                    <span>
                        View Flowers →
                    </span>

                </div>

            </a>

        @empty

            <p>No flower categories found.</p>

        @endforelse

    </div>

</x-admin-layout>