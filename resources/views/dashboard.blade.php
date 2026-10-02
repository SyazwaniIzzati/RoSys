<x-florist-layout>
    <h1 class="page-title">Welcome to RosSys</h1>

    <p class="page-lead">
        Choose a flower option to start exploring our collection.
    </p>

    <div class="category-cards">
        @foreach ($categories as $category)

            <a href="#" class="category-card">
                <div class="category-card-content">
                    <h2>
                        {{ $category->category_name }}
                    </h2>

                    <p>
                        {{ $category->description }}
                    </p>

                    <span class="category-card-link">
                        Explore →
                    </span>
                </div>
            </a>
        @endforeach
    </div>
</x-florist-layout>
