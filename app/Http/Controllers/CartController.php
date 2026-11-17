<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\CartItems;
use App\Models\Flowers;
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

        $cart->load('items.flower');

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
}
