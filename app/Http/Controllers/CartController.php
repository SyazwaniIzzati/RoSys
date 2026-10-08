<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\CartItems;
use App\Models\Flowers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        // Validate the data coming from the frontend
        $validated = $request->validate([
            'flower_id' => 'required|exists:flowers,flower_id',
            'item_type' => 'required|in:stem,bunch',
            'quantity' => 'required|integer|min:1',
        ]);

        // Get the selected flower
        $flower = Flowers::findOrFail($validated['flower_id']);

        // Check whether the flower is available
        if (!$flower->availability) {
            return back()->with('error', 'This flower is currently unavailable.');
        }

        // Determine the price based on item type
        if ($validated['item_type'] === 'stem') {

            $unitPrice = $flower->price_per_stem;

        } else {

            $unitPrice = $flower->price_per_bunch;

            // Make sure bunch price and bunch quantity exist
            if ($unitPrice === null || $flower->bunch_quantity === null) {
                return back()->with(
                    'error',
                    'Bunch purchase is not available for this flower.'
                );
            }
        }

        // Check that the requested quantity is valid for a bunch
        if (
            $validated['item_type'] === 'bunch' &&
            $validated['quantity'] * $flower->bunch_quantity > $flower->stock_quantity
        ) {
            return back()->with(
                'error',
                'Not enough stock available for the requested number of bunches.'
            );
        }

        // Check stem quantity against stock
        if (
            $validated['item_type'] === 'stem' &&
            $validated['quantity'] > $flower->stock_quantity
        ) {
            return back()->with(
                'error',
                'Not enough stock available for the requested number of stems.'
            );
        }

        // Get the customer's cart or create one
        $cart = Carts::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        // Check whether the same flower + same item type
        // already exists in the cart
        $cartItem = CartItems::where('cart_id', $cart->cart_id)
            ->where('flower_id', $flower->flower_id)
            ->where('item_type', $validated['item_type'])
            ->first();

        if ($cartItem) {

            // Add the new quantity to the existing quantity
            $newQuantity = $cartItem->quantity + $validated['quantity'];

            // Check combined quantity against stock
            if ($validated['item_type'] === 'stem') {

                if ($newQuantity > $flower->stock_quantity) {
                    return back()->with(
                        'error',
                        'Not enough stock for the requested quantity.'
                    );
                }

            } else {

                $totalFlowersNeeded =
                    $newQuantity * $flower->bunch_quantity;

                if ($totalFlowersNeeded > $flower->stock_quantity) {
                    return back()->with(
                        'error',
                        'Not enough stock for the requested number of bunches.'
                    );
                }
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->unit_price = $unitPrice;
            $cartItem->subtotal = $newQuantity * $unitPrice;

            $cartItem->save();

        } else {

            // Calculate subtotal for a new cart item
            $subtotal = $validated['quantity'] * $unitPrice;

            CartItems::create([
                'cart_id' => $cart->cart_id,
                'flower_id' => $flower->flower_id,
                'item_type' => $validated['item_type'],
                'quantity' => $validated['quantity'],
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
            ]);
        }

        return back()->with(
            'success',
            $flower->flower_name . ' added to cart successfully.'
        );
    }
}