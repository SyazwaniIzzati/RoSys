<x-florist-layout>
    <div class="customise-page">

        {{-- PAGE HEADER --}}
        <div class="customise-header">
            <p class="eyebrow">ROSYS · CUSTOM BOUQUET</p>
            <h1>Create Your Own Bouquet</h1>
            <p>Choose your flowers and customise your bouquet step by step.</p>
        </div>

        {{-- PROGRESS --}}
        <div class="customise-progress">
            <div class="progress-step active" data-progress="0">
                <span>1</span><small>Flowers</small>
            </div>
            <div class="progress-step" data-progress="1">
                <span>2</span><small>Wrapping</small>
            </div>
            <div class="progress-step" data-progress="2">
                <span>3</span><small>Ribbon</small>
            </div>
            <div class="progress-step" data-progress="3">
                <span>4</span><small>Colour</small>
            </div>
            <div class="progress-step" data-progress="4">
                <span>5</span><small>Style</small>
            </div>
            <div class="progress-step" data-progress="5">
                <span>6</span><small>Review</small>
            </div>
        </div>

        <div class="customise-layout">

            {{-- LEFT: CUSTOMISATION OPTIONS --}}
            <section class="customise-options">

                {{-- STEP 1: FLOWERS (kategori dahulu, kemudian bunga) --}}
                <div class="customise-step active" data-step="0">
                    <h2>Choose Your Flowers</h2>
                    <p class="step-description" id="flowers-description">
                        Pick a category first, then choose your flowers.
                    </p>

                    {{-- A. SENARAI KATEGORI --}}
                    <div class="flower-categories" id="flower-categories">
                        @foreach (($categories ?? collect()) as $category)
                        <button
                            type="button"
                            class="category-pick"
                            data-category-id="{{ $category->category_id }}"
                            data-category-name="{{ $category->category_name }}">

                            @if ($category->image)
                            <img
                                src="{{ asset('storage/' . $category->image) }}"
                                alt="{{ $category->category_name }}"
                                loading="lazy">
                            @else
                            <span class="category-pick-noimg">No image</span>
                            @endif

                            <span class="category-pick-selected" hidden></span>

                            <span class="category-pick-info">
                                <strong>{{ $category->category_name }}</strong>
                                <small>{{ $flowers->where('category_id', $category->category_id)->count() }} flowers</small>
                            </span>
                        </button>
                        @endforeach
                    </div>

                    {{-- B. BUNGA DALAM KATEGORI YANG DIPILIH --}}
                    <div class="flower-browser" id="flower-browser" hidden>

                        <div class="flower-browser-bar">
                            <button type="button" class="flower-back" id="flower-back">
                                ‹ All categories
                            </button>
                            <strong id="flower-category-name"></strong>
                        </div>

                        <div class="flower-options">
                            @forelse ($flowers as $flower)
                            <article
                                class="custom-option flower-option"
                                data-flower-id="{{ $flower->flower_id }}"
                                data-category-id="{{ $flower->category_id }}"
                                data-flower-name="{{ $flower->flower_name }}"
                                data-flower-price="{{ $flower->price_per_stem }}"
                                data-flower-stock="{{ $flower->stock_quantity }}"
                                data-flower-image="{{ $flower->image ? asset('storage/' . $flower->image) : '' }}"
                                data-flower-preview="{{ $flower->image ? asset('storage/' . $flower->image) : '' }}">

                                @if ($flower->image)
                                <img
                                    src="{{ asset('storage/' . $flower->image) }}"
                                    alt="{{ $flower->flower_name }}">
                                @else
                                <div class="option-image-placeholder">
                                    No image available
                                </div>
                                @endif

                                <div class="option-details">
                                    <h3>{{ $flower->flower_name }}</h3>

                                    <p>
                                        RM{{ number_format($flower->price_per_stem, 2) }}
                                        / stem
                                    </p>

                                    <div class="quantity-control">
                                        <button
                                            type="button"
                                            class="quantity-minus"
                                            aria-label="Decrease {{ $flower->flower_name }}">
                                            −
                                        </button>

                                        <span class="quantity-value">0</span>

                                        <button
                                            type="button"
                                            class="quantity-plus"
                                            aria-label="Increase {{ $flower->flower_name }}"
                                            {{ $flower->stock_quantity < 1 ? 'disabled' : '' }}>
                                            +
                                        </button>
                                    </div>

                                    <small>
                                        Stock: {{ $flower->stock_quantity }}
                                    </small>
                                </div>
                            </article>
                            @empty
                            <p>No flowers are currently available.</p>
                            @endforelse
                        </div>

                        <p class="flower-empty" id="flower-empty" hidden>
                            No flowers in this category yet.
                        </p>

                    </div>
                </div>

                {{-- STEP 2: WRAPPING --}}
                <div class="customise-step" data-step="1">
                    <h2>Choose Your Wrapping</h2>
                    <p class="step-description">
                        Select the wrapping for your bouquet.
                    </p>

                    <div class="custom-option-grid">
                        @forelse ($options->get('wrapping', collect()) as $option)
                        <button
                            type="button"
                            class="custom-option selectable-option"
                            data-option-id="{{ $option->option_id }}"
                            data-option-name="{{ $option->option_name }}"
                            data-option-price="{{ $option->price }}"
                            data-option-image="{{ $option->image ? asset('storage/' . $option->image) : '' }}"
                            data-option-preview="{{ $option->image ? asset('storage/' . $option->image) : '' }}"
                            data-option-type="wrapping">

                            @if ($option->image)
                            <img
                                src="{{ asset('storage/' . $option->image) }}"
                                alt="{{ $option->option_name }}">
                            @else
                            <span class="option-image-placeholder">
                                No image
                            </span>
                            @endif

                            <strong>{{ $option->option_name }}</strong>
                            <span>RM{{ number_format($option->price, 2) }}</span>
                        </button>
                        @empty
                        <p>No wrapping options available.</p>
                        @endforelse
                    </div>
                </div>

                {{-- STEP 3: RIBBON --}}
                <div class="customise-step" data-step="2">
                    <h2>Choose Your Ribbon</h2>
                    <p class="step-description">
                        Select a ribbon to complete your bouquet.
                    </p>

                    <div class="custom-option-grid">
                        @forelse ($options->get('ribbon', collect()) as $option)
                        <button
                            type="button"
                            class="custom-option selectable-option"
                            data-option-id="{{ $option->option_id }}"
                            data-option-name="{{ $option->option_name }}"
                            data-option-price="{{ $option->price }}"
                            data-option-image="{{ $option->image ? asset('storage/' . $option->image) : '' }}"
                            data-option-preview="{{ $option->image ? asset('storage/' . $option->image) : '' }}"
                            data-option-type="ribbon">

                            @if ($option->image)
                            <img
                                src="{{ asset('storage/' . $option->image) }}"
                                alt="{{ $option->option_name }}">
                            @else
                            <span class="option-image-placeholder">
                                No image
                            </span>
                            @endif

                            <strong>{{ $option->option_name }}</strong>
                            <span>RM{{ number_format($option->price, 2) }}</span>
                        </button>
                        @empty
                        <p>No ribbon options available.</p>
                        @endforelse
                    </div>
                </div>

                {{-- STEP 4: THEME COLOUR --}}
                <div class="customise-step" data-step="3">
                    <h2>Choose Your Theme Colour</h2>
                    <p class="step-description">
                        Choose the colour theme for your bouquet.
                    </p>

                    <div class="custom-option-grid">
                        @forelse ($options->get('theme_colour', collect()) as $option)
                        <button
                            type="button"
                            class="custom-option selectable-option"
                            data-option-id="{{ $option->option_id }}"
                            data-option-name="{{ $option->option_name }}"
                            data-option-price="{{ $option->price }}"
                            data-option-image="{{ $option->image ? asset('storage/' . $option->image) : '' }}"
                            data-option-preview="{{ $option->image ? asset('storage/' . $option->image) : '' }}"
                            data-option-type="theme_colour">

                            @if ($option->image)
                            <img
                                src="{{ asset('storage/' . $option->image) }}"
                                alt="{{ $option->option_name }}">
                            @else
                            <span class="option-image-placeholder">
                                No image
                            </span>
                            @endif

                            <strong>{{ $option->option_name }}</strong>
                            <span>RM{{ number_format($option->price, 2) }}</span>
                        </button>
                        @empty
                        <p>No theme colours available.</p>
                        @endforelse
                    </div>
                </div>

                {{-- STEP 5: BOUQUET STYLE --}}
                <div class="customise-step" data-step="4">
                    <h2>Choose Your Bouquet Style</h2>
                    <p class="step-description">
                        Select the arrangement style you prefer.
                    </p>

                    <div class="custom-option-grid">
                        @forelse ($options->get('bouquet_style', collect()) as $option)
                        <button
                            type="button"
                            class="custom-option selectable-option"
                            data-option-id="{{ $option->option_id }}"
                            data-option-name="{{ $option->option_name }}"
                            data-option-price="{{ $option->price }}"
                            data-option-image="{{ $option->image ? asset('storage/' . $option->image) : '' }}"
                            data-option-preview="{{ $option->image ? asset('storage/' . $option->image) : '' }}"
                            data-option-type="bouquet_style">

                            @if ($option->image)
                            <img
                                src="{{ asset('storage/' . $option->image) }}"
                                alt="{{ $option->option_name }}">
                            @else
                            <span class="option-image-placeholder">
                                No image
                            </span>
                            @endif

                            <strong>{{ $option->option_name }}</strong>
                            <span>RM{{ number_format($option->price, 2) }}</span>
                        </button>
                        @empty
                        <p>No bouquet styles available.</p>
                        @endforelse
                    </div>
                </div>

                {{-- STEP 6: REVIEW --}}
                <div class="customise-step" data-step="5">
                    <h2>Review Your Bouquet</h2>
                    <p class="step-description">
                        Check your selections before adding your bouquet to the cart.
                    </p>

                    <div id="review-summary"></div>

                    <p class="review-note">
                        Your final order will be subject to stock availability.
                    </p>
                </div>

                {{-- NAVIGATION --}}
                <div class="step-navigation">
                    <button type="button" id="previous-step" disabled>
                        Back
                    </button>

                    <button type="button" id="next-step">
                        Next
                    </button>
                </div>

            </section>

            {{-- RIGHT: LIVE BOUQUET PREVIEW --}}
            <aside class="live-preview">

                <div class="preview-heading">
                    <span>LIVE PREVIEW</span>
                    <h2>Your Bouquet</h2>
                    <p>Your selections will appear here.</p>
                </div>

                <div class="preview-image-area" id="preview-canvas">

                    {{-- EMPTY STATE --}}
                    <div id="preview-empty">
                        <p>Select flowers to start building your bouquet.</p>
                    </div>

                    {{-- LAYERED BOUQUET --}}
                    <div id="preview-content"
                        class="bouquet-composition"
                        hidden>

                        {{-- Theme colour glow (backdrop) --}}
                        <div id="preview-backdrop" class="bouquet-backdrop"></div>

                        {{-- Back layer (Wrapping) --}}
                        <div
                            id="preview-wrapping"
                            class="bouquet-layer wrapping-layer">
                        </div>

                        {{-- Middle layer (Flower Cluster) --}}
                        <div
                            id="preview-flowers"
                            class="bouquet-layer flowers-layer">
                        </div>

                        {{-- Front layer (Ribbon) --}}
                        <div
                            id="preview-ribbon"
                            class="bouquet-layer ribbon-layer">
                        </div>

                        {{-- Theme colour and style labels --}}
                        <div class="bouquet-preview-labels">
                            <span id="preview-theme"></span>
                            <span id="preview-style"></span>
                        </div>
                    </div>

                </div>

                {{-- SELECTION SUMMARY --}}
                <div class="preview-summary">
                    <h3>Selected Items</h3>

                    <div id="preview-selections">
                        <p class="empty-selection">
                            No items selected yet.
                        </p>
                    </div>

                    <div class="preview-total">
                        <span>Estimated Total</span>
                        <strong id="preview-total">RM0.00</strong>
                    </div>

                    <p class="preview-disclaimer">
                        The preview is illustrative. The final physical
                        arrangement may vary.
                    </p>
                </div>

            </aside>

        </div>
    </div>

    @push('styles')
    @vite('resources/css/customise.css')
    @endpush

    @push('scripts')
    @vite('resources/js/customise.js')
    @endpush
</x-florist-layout>