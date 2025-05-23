<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $carts = Cart::where('user_id', Auth::user()->id)->get();

        $carts = Auth::user()->carts;

        $total = $carts->map(function ($cart) {
            $cart->total = $cart->product->price * $cart->quantity;

            return $cart;
        })
            ->pluck('total')->sum();

        return view('carts.show', [
            'carts' => $carts,
            'total' => $total,
        ]);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store($id)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(StoreRequest $request, Product $product)
    {
        $request->validated();

        $cart = Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->quantity += 1;
            $cart->save();
        } else {
            $cart = new Cart();
            $cart->user_id = Auth::user()->id;
            $cart->product_id = $product->id;
            $cart->save();
        }

        $product->stock -= 1;
        $product->save();

        return redirect()->back();
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $action = $request->action;

        $cart = Cart::find($id);

        switch ($action) {
            case 'minus':
                $qty = $cart->quantity - 1;

                if ($qty < 1) {
                    $cart->delete();
                    break;
                } else {
                    $cart->quantity -= 1;
                    $cart->save();
                    break;
                }

            case 'plus':
                $cart->quantity += 1;
                $cart->save();
                break;
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
