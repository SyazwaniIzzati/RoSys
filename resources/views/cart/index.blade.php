<x-florist-layout>
    @push('styles')
    @vite('resources/css/cart.css')
    @endpush

    <div class="cart-page">
        <div class="cart-heading">
            <h1>Your Shopping Cart</h1>
            <p>Review your selected flowers before checkout.</p>
        </div>

        @if (session('success'))
        <div class="cart-alert cart-alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="cart-alert cart-alert-error">
            {{ session('error') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="cart-alert cart-alert-error">
            @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        @if (!$cart || $cart->items->isEmpty())
        <div class="cart-panel cart-empty">
            <h2>Your cart is empty</h2>
            <p>You haven't added any flowers yet.</p>

            <a href="{{ route('flowers.index') }}"
                class="cart-primary-button"
                style="max-width:240px; margin:24px auto 0;">
                Continue Shopping
            </a>
        </div>
        @else
        <div class="cart-layout">
            <section class="cart-panel">
                <h2 class="cart-panel-title">
                    Cart Items ({{ $cart->items->count() }})
                </h2>

                @foreach ($cart->items as $item)
                @php
                $isCustomBouquet = $item->item_type === 'custom_bouquet';
                $customisation = $isCustomBouquet ? $item->customisation : null;
                @endphp

                <article class="cart-item">

                    @if ($isCustomBouquet && $customisation?->preview_image)
                    <img
                        class="cart-item-image"
                        src="{{ asset('storage/' . $customisation->preview_image) }}"
                        alt="Custom bouquet preview">
                    @elseif ($item->flower && $item->flower->image)
                    <img
                        class="cart-item-image"
                        src="{{ asset('storage/' . $item->flower->image) }}"
                        alt="{{ $item->flower->flower_name }}">
                    @else
                    <div class="cart-item-image"
                        style="display:flex;align-items:center;justify-content:center;color:#888;font-size:12px;">
                        No image
                    </div>
                    @endif

                    <div class="cart-item-details">
                        <h3 class="cart-item-name">
                            @if ($isCustomBouquet)
                            {{ $customisation?->bouquetStyleOption?->option_name ?? 'Custom Bouquet' }}
                            @else
                            {{ $item->flower->flower_name ?? 'Flower unavailable' }}
                            @endif
                        </h3>

                        <div class="cart-item-type">
                            {{ $isCustomBouquet ? 'Custom Bouquet' : ucfirst($item->item_type) }}
                        </div>

                        @if ($isCustomBouquet && $customisation)
                        {{-- Selected flowers --}}
                        <div style="font-size:13px; margin-top:10px;">
                            <strong>Flowers:</strong>
                            @forelse ($customisation->items as $customFlower)
                            <div>
                                {{ $customFlower->flower->flower_name ?? 'Flower unavailable' }}
                                × {{ $customFlower->quantity }}
                            </div>
                            @empty
                            <div>No flower details available.</div>
                            @endforelse
                        </div>

                        {{-- Selected customisation options --}}
                        @if ($customisation->wrappingOption)
                        <div style="font-size:13px; margin-top:6px;">
                            <strong>Wrapping:</strong>
                            {{ $customisation->wrappingOption->option_name }}
                        </div>
                        @endif

                        @if ($customisation->ribbonOption)
                        <div style="font-size:13px; margin-top:6px;">
                            <strong>Ribbon:</strong>
                            {{ $customisation->ribbonOption->option_name }}
                        </div>
                        @endif

                        @if ($customisation->themeColourOption)
                        <div style="font-size:13px; margin-top:6px;">
                            <strong>Theme Colour:</strong>
                            {{ $customisation->themeColourOption->option_name }}
                        </div>
                        @endif

                        @if ($customisation->bouquetStyleOption)
                        <div style="font-size:13px; margin-top:6px;">
                            <strong>Bouquet Style:</strong>
                            {{ $customisation->bouquetStyleOption->option_name }}
                        </div>
                        @endif

                        @if ($customisation->special_request)
                        <div style="font-size:13px; margin-top:6px;">
                            <strong>Special Request:</strong>
                            {{ $customisation->special_request }}
                        </div>
                        @endif

                        <div class="cart-item-price" style="margin-top:10px;">
                            RM {{ number_format((float) $item->unit_price, 2) }}
                            / custom bouquet
                        </div>
                        @else
                        <div class="cart-item-price">
                            RM {{ number_format((float) $item->unit_price, 2) }}
                            / {{ $item->item_type === 'bunch' ? 'bunch' : 'stem' }}
                        </div>
                        @endif

                        <div class="cart-item-actions">
                            @if (!$isCustomBouquet)
                            <form
                                method="POST"
                                action="{{ route('cart.update', $item->cart_item_id) }}"
                                class="quantity-form">
                                @csrf
                                @method('PATCH')

                                <label
                                    for="quantity-{{ $item->cart_item_id }}"
                                    style="font-size:12px;">
                                    Qty
                                </label>

                                <input
                                    id="quantity-{{ $item->cart_item_id }}"
                                    type="number"
                                    name="quantity"
                                    min="1"
                                    max="999"
                                    value="{{ $item->quantity }}"
                                    required>

                                <button type="submit" class="small-button">
                                    Update
                                </button>
                            </form>
                            @else
                            <div style="font-size:12px;">
                                Qty: {{ $item->quantity }} custom bouquet
                            </div>
                            @endif

                            <button
                                type="button"
                                class="remove-button js-open-remove-modal"
                                data-remove-url="{{ route('cart.destroy', $item->cart_item_id) }}"
                                data-flower-name="{{ $isCustomBouquet
                                    ? ($customisation?->bouquetStyleOption?->option_name ?? 'Custom Bouquet')
                                    : ($item->flower->flower_name ?? 'this flower') }}">
                                Remove
                            </button>
                        </div>

                        <p style="font-size:14px;font-weight:500;margin:14px 0 0;">
                            Subtotal: RM {{ number_format((float) $item->subtotal, 2) }}
                        </p>
                    </div>
                </article>
                @endforeach

                <a href="{{ route('flowers.index') }}"
                    class="cart-secondary-button">
                    Continue Shopping
                </a>
            </section>

            <aside class="summary-panel">
                <h2>Order Summary</h2>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>RM {{ number_format((float) $subtotal, 2) }}</span>
                </div>

                <div class="summary-row">
                    <span>Delivery</span>
                    <span>Calculated at checkout</span>
                </div>

                <div class="summary-row summary-total">
                    <span>Total</span>
                    <span>RM {{ number_format((float) $subtotal, 2) }}</span>
                </div>

                <p class="summary-note">
                    Delivery charges, payment method and final order
                    confirmation will be handled during checkout.
                </p>

                <button
                    type="button"
                    class="cart-primary-button"
                    disabled
                    title="Checkout has not been implemented yet">
                    Make Payment
                </button>

                <a href="{{ route('flowers.index') }}"
                    class="cart-secondary-button">
                    Continue Shopping
                </a>
            </aside>
        </div>
        @endif
    </div>

    {{-- Remove Confirmation Modal --}}
    <div id="removeCartModal" class="remove-modal" hidden>
        <div class="remove-modal-backdrop" data-close-remove-modal></div>

        <section
            class="remove-modal-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="removeModalTitle"
            aria-describedby="removeModalDescription">

            <div class="remove-modal-icon">
                <svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.7"
                    stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="M3 6h18" />
                    <path d="M8 6V4h8v2" />
                    <path d="m19 6-1 14H6L5 6" />
                    <path d="M10 11v5M14 11v5" />
                </svg>
            </div>

            <h2 id="removeModalTitle">Remove Item?</h2>

            <p id="removeModalDescription" class="remove-modal-message">
                Are you sure you want to remove
                <span id="removeFlowerName" class="remove-modal-flower">
                    this flower
                </span>
                from your cart? This action cannot be undone.
            </p>

            <div class="remove-modal-actions">
                <button
                    type="button"
                    id="cancelRemoveButton"
                    class="remove-cancel-button">
                    Cancel
                </button>

                <form id="removeCartForm" method="POST" action="">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="remove-confirm-button">
                        Remove Item
                    </button>
                </form>
            </div>
        </section>
    </div>

    <script>
        (function() {
            function initialiseRemoveModal() {
                const modal = document.getElementById('removeCartModal');

                if (!modal || modal.dataset.initialised === 'true') {
                    return;
                }

                const removeForm = document.getElementById('removeCartForm');
                const flowerName = document.getElementById('removeFlowerName');
                const cancelButton = document.getElementById('cancelRemoveButton');

                if (!removeForm || !flowerName || !cancelButton) {
                    console.error('Remove modal HTML elements are missing.');
                    return;
                }

                modal.dataset.initialised = 'true';

                let previousFocus = null;

                function openModal(button) {
                    previousFocus = button;
                    removeForm.action = button.dataset.removeUrl;
                    flowerName.textContent =
                        button.dataset.flowerName || 'this flower';

                    modal.hidden = false;
                    document.body.style.overflow = 'hidden';
                    cancelButton.focus();
                }

                function closeModal() {
                    modal.hidden = true;
                    document.body.style.overflow = '';

                    if (previousFocus && document.contains(previousFocus)) {
                        previousFocus.focus();
                    }
                }

                document.querySelectorAll('.js-open-remove-modal')
                    .forEach(function(button) {
                        button.addEventListener('click', function() {
                            openModal(button);
                        });
                    });

                cancelButton.addEventListener('click', closeModal);

                modal.querySelectorAll('[data-close-remove-modal]')
                    .forEach(function(element) {
                        element.addEventListener('click', closeModal);
                    });

                document.addEventListener('keydown', function(event) {
                    if (!modal.hidden && event.key === 'Escape') {
                        closeModal();
                    }
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener(
                    'DOMContentLoaded',
                    initialiseRemoveModal
                );
            } else {
                initialiseRemoveModal();
            }
        })();
    </script>
</x-florist-layout>