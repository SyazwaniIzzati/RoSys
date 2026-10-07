<x-florist-layout>

    <h1 class="page-title">Welcome to RosSys</h1>

    <p class="page-lead">
        Choose a flower option to start exploring our collection.
    </p>

    <div class="category-cards">

        @foreach ($categories as $category)

            <a href="#" class="category-card">

                {{-- Category Image --}}
                @if ($category->image)
                    <img
                        src="{{ asset('storage/' . $category->image) }}"
                        alt="{{ $category->category_name }}"
                        class="category-card-image"
                    >
                @endif

                <div class="category-card-content">

                    {{-- Category Name --}}
                    <h2>
                        {{ $category->category_name }}
                    </h2>

                    {{-- Description --}}
                    <p>
                        {{ $category->description ?: 'Explore our collection.' }}
                    </p>

                    {{-- Explore Link --}}
                    <span class="category-card-link">
                        Explore →
                    </span>

                </div>

            </a>

        @endforeach

    </div>

</x-florist-layout>