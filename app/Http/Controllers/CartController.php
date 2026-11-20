<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\CartItems;
use App\Models\Flowers;
use App\Models\BouquetCustomisation;
use App\Models\CustomBouquetItem;
use App\Models\CustomisationOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display the customer's cart.
     */

    public function index()
    {
        $cart = Carts::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        $cart->load([
            'items.flower',
            'items.customisation.items.flower',
            'items.customisation.wrappingOption',
            'items.customisation.ribbonOption',
            'items.customisation.themeColourOption',
            'items.customisation.bouquetStyleOption',
        ]);

        $subtotal = $cart->items->sum('subtotal');

        return view('cart.index', compact(
            'cart',
            'subtotal'
        ));
    }

    /**
     * Add a flower to the cart.
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'flower_id' => 'required|exists:flowers,flower_id',
            'item_type' => 'required|in:stem,bunch',
            'quantity' => 'required|integer|min:1',
        ]);

        $flower = Flowers::findOrFail(
            $validated['flower_id']
        );

        if (!$flower->availability) {
            return back()->with(
                'error',
                'This flower is currently unavailable.'
            );
        }

        if ($validated['item_type'] === 'stem') {
            $unitPrice = $flower->price_per_stem;

            if ($unitPrice === null) {
                return back()->with(
                    'error',
                    'Stem purchase is not available for this flower.'
                );
            }
        } else {
            $unitPrice = $flower->price_per_bunch;

            if (
                $unitPrice === null ||
                !$flower->bunch_quantity ||
                $flower->bunch_quantity < 1
            ) {
                return back()->with(
                    'error',
                    'Bunch purchase is not available for this flower.'
                );
            }
        }

        $cart = Carts::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        try {
            DB::transaction(function () use (
                $validated,
                $flower,
                $cart,
                $unitPrice
            ) {
                $cartItem = CartItems::where(
                    'cart_id',
                    $cart->cart_id
                )
                    ->where('flower_id', $flower->flower_id)
                    ->where('item_type', $validated['item_type'])
                    ->lockForUpdate()
                    ->first();

                $newQuantity = (
                    $cartItem ? $cartItem->quantity : 0
                ) + $validated['quantity'];

                $flowersNeeded = $validated['item_type'] === 'bunch'
                    ? $newQuantity * $flower->bunch_quantity
                    : $newQuantity;

                if ($flowersNeeded > $flower->stock_quantity) {
                    throw new \RuntimeException(
                        'Not enough stock for the requested quantity.'
                    );
                }

                if ($cartItem) {
                    $cartItem->quantity = $newQuantity;
                    $cartItem->unit_price = $unitPrice;
                    $cartItem->subtotal = $newQuantity * $unitPrice;
                    $cartItem->save();
                } else {
                    CartItems::create([
                        'cart_id' => $cart->cart_id,
                        'flower_id' => $flower->flower_id,
                        'item_type' => $validated['item_type'],
                        'quantity' => $validated['quantity'],
                        'unit_price' => $unitPrice,
                        'subtotal' => $validated['quantity'] * $unitPrice,
                    ]);
                }
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with(
            'success',
            $flower->flower_name . ' added to cart successfully.'
        );
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, $cartItemId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItems::where(
            'cart_item_id',
            $cartItemId
        )
            ->whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with('flower')
            ->firstOrFail();

        $flower = $cartItem->flower;
        $quantity = (int) $validated['quantity'];

        if (!$flower || !$flower->availability) {
            return back()->with(
                'error',
                'This flower is currently unavailable.'
            );
        }

        $flowersNeeded = $cartItem->item_type === 'bunch'
            ? $quantity * $flower->bunch_quantity
            : $quantity;

        if ($flowersNeeded > $flower->stock_quantity) {
            return back()->with(
                'error',
                'Not enough stock for the requested quantity.'
            );
        }

        $cartItem->quantity = $quantity;
        $cartItem->subtotal = $quantity * $cartItem->unit_price;
        $cartItem->save();

        return back()->with(
            'success',
            'Cart quantity updated successfully.'
        );
    }

    /**
     * Remove an item from the customer's cart.
     */
    public function destroy($cartItemId)
    {
        $cartItem = CartItems::where(
            'cart_item_id',
            $cartItemId
        )
            ->whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $cartItem->delete();

        return back()->with(
            'success',
            'Item removed from cart successfully.'
        );
    }


    /**
     * Add a custom bouquet to the customer's cart.
     */
    public function addCustomBouquet(Request $request)
    {
        $validated = $request->validate([
            'flowers' => 'required|array|min:1',
            'flowers.*.flower_id' => 'required|integer|distinct|exists:flowers,flower_id',
            'flowers.*.quantity' => 'required|integer|min:1',
            'wrapping_option_id' => 'nullable|integer|exists:customisation_options,option_id',
            'ribbon_option_id' => 'nullable|integer|exists:customisation_options,option_id',
            'theme_colour_option_id' => 'nullable|integer|exists:customisation_options,option_id',
            'bouquet_style_option_id' => 'nullable|integer|exists:customisation_options,option_id',
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'special_request' => 'nullable|string|max:1000',
        ]);

        $cart = Carts::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        try {

            $previewPath = null;

            if (isset($validated['preview_image'])) {
                $previewPath = $validated['preview_image']->store(
                    'bouquet-previews',
                    'public'
                );
            }

            DB::transaction(function () use ($validated, $cart, $previewPath) {
                $flowerDetails = [];
                $total = 0;

                /*
             * Validate flower availability and calculate prices
             * using database values, not prices from JavaScript.
             */
                foreach ($validated['flowers'] as $selected) {
                    $flower = Flowers::where(
                        'flower_id',
                        $selected['flower_id']
                    )->lockForUpdate()->firstOrFail();

                    $quantity = (int) $selected['quantity'];

                    if (!$flower->availability) {
                        throw new \RuntimeException(
                            $flower->flower_name . ' is unavailable.'
                        );
                    }

                    if ($quantity > (int) $flower->stock_quantity) {
                        throw new \RuntimeException(
                            'Not enough stock for ' . $flower->flower_name . '.'
                        );
                    }

                    if ($flower->price_per_stem === null) {
                        throw new \RuntimeException(
                            'Stem pricing is unavailable for ' .
                                $flower->flower_name . '.'
                        );
                    }

                    $unitPrice = (float) $flower->price_per_stem;
                    $lineTotal = round($unitPrice * $quantity, 2);

                    $flowerDetails[] = [
                        'flower' => $flower,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'subtotal' => $lineTotal,
                    ];

                    $total += $lineTotal;
                }

                /*
             * Validate each selected option's type and availability.
             * Option prices also come from the database.
             */
                $optionFields = [
                    'wrapping_option_id' => 'wrapping',
                    'ribbon_option_id' => 'ribbon',
                    'theme_colour_option_id' => 'theme_colour',
                    'bouquet_style_option_id' => 'bouquet_style',
                ];

                $selectedOptionIds = [];

                foreach ($optionFields as $field => $expectedType) {
                    $optionId = $validated[$field] ?? null;

                    if (!$optionId) {
                        continue;
                    }

                    $option = CustomisationOption::where(
                        'option_id',
                        $optionId
                    )->lockForUpdate()->firstOrFail();

                    if ($option->option_type !== $expectedType) {
                        throw new \RuntimeException(
                            'One of the selected customisation options is invalid.'
                        );
                    }

                    if (!$option->availability) {
                        throw new \RuntimeException(
                            $option->option_name . ' is unavailable.'
                        );
                    }

                    if (
                        in_array($expectedType, ['wrapping', 'ribbon'], true)
                        && (int) $option->stock_quantity < 1
                    ) {
                        throw new \RuntimeException(
                            $option->option_name . ' is out of stock.'
                        );
                    }

                    $selectedOptionIds[$field] = $option->option_id;
                    $total += (float) $option->price;
                }

                $total = round($total, 2);

                /*
             * Save the bouquet design.
             */
                $customisation = BouquetCustomisation::create([
                    'user_id' => Auth::id(),
                    'bouquet_type' => 'custom',
                    'special_request' => $validated['special_request'] ?? null,
                    'wrap_option_id' => $selectedOptionIds['wrapping_option_id'] ?? null,
                    'ribbon_option_id' => $selectedOptionIds['ribbon_option_id'] ?? null,
                    'theme_colour_option_id' => $selectedOptionIds['theme_colour_option_id'] ?? null,
                    'bouquet_style_option_id' => $selectedOptionIds['bouquet_style_option_id'] ?? null,
                    'preview_image' => $previewPath,
                ]);

                /*
             * Save each flower and its individual stem quantity.
             */
                foreach ($flowerDetails as $detail) {
                    CustomBouquetItem::create([
                        'customisation_id' => $customisation->customisation_id,
                        'flower_id' => $detail['flower']->flower_id,
                        'quantity' => $detail['quantity'],
                        'unit_price' => $detail['unit_price'],
                        'subtotal' => $detail['subtotal'],
                    ]);
                }

                /*
             * Save one cart line for the entire custom bouquet.
             * No inventory is deducted here.
             */
                CartItems::create([
                    'cart_id' => $cart->cart_id,
                    'flower_id' => null,
                    'customisation_id' => $customisation->customisation_id,
                    'item_type' => 'custom_bouquet',
                    'quantity' => 1,
                    'unit_price' => $total,
                    'subtotal' => $total,
                ]);
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Your custom bouquet has been added to your cart.');
    }
}
