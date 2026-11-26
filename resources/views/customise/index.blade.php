<x-florist-layout>
    <div class="customise-page">

        {{-- HEADER --}}
        <div class="customise-header">
            <p class="eyebrow">ROSYS · CUSTOM BOUQUET</p>
            <h1>Create Your Own Bouquet</h1>
            <p>Choose your flowers and customise your bouquet step by step.</p>
        </div>

        {{-- PROGRESS --}}
        <div class="customise-progress">
            @foreach (['Flowers', 'Wrapping', 'Ribbon', 'Colour', 'Style', 'Review'] as $index => $label)
                <div class="progress-step {{ $index === 0 ? 'active' : '' }}"
                     data-progress="{{ $index }}">
                    <span>{{ $index + 1 }}</span>
                    <small>{{ $label }}</small>
                </div>
            @endforeach
        </div>

        <div class="customise-layout">

            {{-- LEFT: CUSTOMISATION --}}
            <section class="customise-options">

                {{-- STEP 1: FLOWERS --}}
                <div class="customise-step active" data-step="0">
                    <h2>Choose Your Flowers</h2>
                    <p class="step-description" id="flowers-description">
                        Pick a category first, then choose your flowers.
                    </p>

                    <div class="flower-categories" id="flower-categories">
                        @foreach (($categories ?? collect()) as $category)
                            <button type="button"
                                    class="category-pick"
                                    data-category-id="{{ $category->category_id }}"
                                    data-category-name="{{ $category->category_name }}">

                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}"
                                         alt="{{ $category->category_name }}"
                                         loading="lazy">
                                @else
                                    <span class="category-pick-noimg">No image</span>
                                @endif

                                <span class="category-pick-selected" hidden></span>

                                <span class="category-pick-info">
                                    <strong>{{ $category->category_name }}</strong>
                                    <small>
                                        {{ $flowers->where('category_id', $category->category_id)->count() }}
                                        flowers
                                    </small>
                                </span>
                            </button>
                        @endforeach
                    </div>

                    <div class="flower-browser" id="flower-browser" hidden>
                        <div class="flower-browser-bar">
                            <button type="button" class="flower-back" id="flower-back">
                                ‹ All categories
                            </button>
                            <strong id="flower-category-name"></strong>
                        </div>

                        <div class="flower-options">
                            @forelse ($flowers as $flower)
                                <article class="custom-option flower-option"
                                         data-flower-id="{{ $flower->flower_id }}"
                                         data-category-id="{{ $flower->category_id }}"
                                         data-category-name="{{ $categories->firstWhere('category_id', $flower->category_id)?->category_name }}"
                                         data-flower-name="{{ $flower->flower_name }}"
                                         data-flower-price="{{ $flower->price_per_stem }}"
                                         data-flower-stock="{{ $flower->stock_quantity }}">

                                    @if ($flower->image)
                                        <img src="{{ asset('storage/' . $flower->image) }}"
                                             alt="{{ $flower->flower_name }}"
                                             loading="lazy">
                                    @else
                                        <div class="option-image-placeholder">
                                            No image available
                                        </div>
                                    @endif

                                    <div class="option-details">
                                        <h3>{{ $flower->flower_name }}</h3>
                                        <p>RM{{ number_format($flower->price_per_stem, 2) }} / stem</p>

                                        <div class="quantity-control">
                                            <button type="button"
                                                    class="quantity-minus"
                                                    aria-label="Decrease {{ $flower->flower_name }}">
                                                −
                                            </button>

                                            <span class="quantity-value">0</span>

                                            <button type="button"
                                                    class="quantity-plus"
                                                    aria-label="Increase {{ $flower->flower_name }}"
                                                    {{ $flower->stock_quantity < 1 ? 'disabled' : '' }}>
                                                +
                                            </button>
                                        </div>

                                        <small>Stock: {{ $flower->stock_quantity }}</small>
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

                {{-- STEPS 2–5: CUSTOMISATION OPTIONS --}}
                @php
                    $customisationSteps = [
                        'wrapping' => [
                            'title' => 'Choose Your Wrapping',
                            'description' => 'Select the wrapping for your bouquet.',
                            'step' => 1,
                        ],
                        'ribbon' => [
                            'title' => 'Choose Your Ribbon',
                            'description' => 'Select a ribbon to complete your bouquet.',
                            'step' => 2,
                        ],
                        'theme_colour' => [
                            'title' => 'Choose Your Theme Colour',
                            'description' => 'Choose the colour theme for your bouquet.',
                            'step' => 3,
                        ],
                        'bouquet_style' => [
                            'title' => 'Choose Your Bouquet Style',
                            'description' => 'Select the arrangement style you prefer.',
                            'step' => 4,
                        ],
                    ];
                @endphp

                @foreach ($customisationSteps as $type => $config)
                    <div class="customise-step" data-step="{{ $config['step'] }}">
                        <h2>{{ $config['title'] }}</h2>
                        <p class="step-description">{{ $config['description'] }}</p>

                        <div class="custom-option-grid">
                            @forelse ($options->get($type, collect()) as $option)
                                <button type="button"
                                        class="custom-option selectable-option"
                                        data-option-id="{{ $option->option_id }}"
                                        data-option-name="{{ $option->option_name }}"
                                        data-option-price="{{ $option->price }}"
                                        data-option-type="{{ $type }}">

                                    @if ($option->image)
                                        <img src="{{ asset('storage/' . $option->image) }}"
                                             alt="{{ $option->option_name }}"
                                             loading="lazy">
                                    @else
                                        <span class="option-image-placeholder">No image</span>
                                    @endif

                                    <strong>{{ $option->option_name }}</strong>
                                    <span>RM{{ number_format($option->price, 2) }}</span>
                                </button>
                            @empty
                                <p>No {{ str_replace('_', ' ', $type) }} options available.</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach

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
                    <button type="button" id="previous-step" disabled>Back</button>
                    <button type="button" id="next-step">Next</button>
                </div>

            </section>

            {{-- RIGHT: AI DESIGNER & LIVE PREVIEW --}}
            <aside class="live-preview">

                <section class="ai-bouquet-generator">
                    <div class="ai-bouquet-header">
                        <p class="eyebrow">ROSYS · AI DESIGNER</p>
                        <h2>Design Your Bouquet</h2>
                        <p>
                            Describe your ideal bouquet and let AI create three design suggestions.
                        </p>
                    </div>

                    <div class="ai-bouquet-input">
                        <label for="ai-bouquet-prompt">Describe your bouquet</label>

                        <textarea id="ai-bouquet-prompt"
                                  maxlength="500"
                                  rows="3"
                                  placeholder="Example: 3 red roses, white baby's breath, green leaves, cream wrapping and a red ribbon."></textarea>

                        <small>Include your preferred flowers, colours and wrapping.</small>

                        <button type="button" id="generate-ai-bouquet">
                            Generate 3 Designs
                        </button>

                        <p id="ai-bouquet-status"
                           role="status"
                           aria-live="polite"
                           hidden></p>
                    </div>

                    <div id="ai-bouquet-results" class="ai-bouquet-results" hidden>
                        <h3>Choose Your Favourite Design</h3>
                        <div id="ai-bouquet-images" class="ai-bouquet-images"></div>
                    </div>

                    <input type="hidden" id="selected-ai-bouquet-url" value="">
                </section>

                {{-- AI IMAGE ONLY --}}
                <div class="preview-heading">
                    <span>LIVE PREVIEW</span>
                    <h2>Your Bouquet</h2>
                    <p>Select an AI design to see it here.</p>
                </div>

                <div class="preview-image-area" id="preview-canvas">
                    <div id="preview-empty">
                        <p>Generate your designs and select your favourite bouquet.</p>
                    </div>
                </div>

                {{-- AI MATERIALS --}}
                <section id="ai-bouquet-materials" class="ai-bouquet-materials" hidden>
                    <h3>Suggested Materials</h3>
                    <p>Estimated materials for your selected design.</p>
                    <div id="ai-bouquet-material-list"></div>
                    <small>
                        Quantities are AI estimates and may differ from the final arrangement.
                    </small>
                </section>

                {{-- PRICE SUMMARY --}}
                <div class="preview-summary">
                    <h3>Selected Items</h3>

                    <div id="preview-selections">
                        <p class="empty-selection">No items selected yet.</p>
                    </div>

                    <div class="preview-total">
                        <span>Estimated Total</span>
                        <strong id="preview-total">RM0.00</strong>
                    </div>

                    <p class="preview-disclaimer">
                        The preview is illustrative. The final physical arrangement may vary.
                    </p>
                </div>

                <span id="preview-theme" hidden></span>
                <span id="preview-style" hidden></span>

            </aside>
        </div>
    </div>

    {{-- CART FORM --}}
    <form id="custom-bouquet-cart-form"
          method="POST"
          action="{{ route('cart.add-custom-bouquet') }}"
          enctype="multipart/form-data"
          hidden>
        @csrf

        <input type="file"
               name="preview_image"
               id="preview-image-input"
               accept="image/png,image/jpeg,image/webp"
               hidden>

        <input type="hidden" name="special_request" value="">
    </form>

    @push('styles')
        @vite('resources/css/customise.css')
    @endpush

    @push('scripts')
        @vite('resources/js/customise.js')
    @endpush
</x-florist-layout>
