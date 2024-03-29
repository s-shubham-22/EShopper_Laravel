<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart', [
            // 'carts' => Cart::where('product_id', Auth::user()->id)->with('product')->get()
            'carts' => Cart::where('user_id', Auth::user()->id)->with('product')->with('variant')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        //$validated = $request->validated();
        $validated['created_by'] = Auth::user()->id;

        $cart = Cart::updateOrCreate([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'variant_id' => $request->variant_id
            //'quantity' => $request->quantity,
        ],
        [
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'variant_id' => $request->variant_id
            //'quantity' => $request->quantity,
        ]);

        $cart->increment('quantity',$request->quantity);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = cart::find($id);
        if($cart->delete()) {
            return response()->json([
                'success' => 'Product Deleted Successfully!'
            ]);
        } else {
            return response()->json([
                'error' => 'Product not Deleted!'
            ]);
        }
    }

    public function change_quantity(Request $request)
    {
        $cart = Cart::where('user_id', Auth::user()->id)
        ->where('variant_id', $request->id)
        ->first();

        $cart['quantity'] = $request->quantity;
        $cart->save();

        $quantity = $cart->quantity;
        if($quantity == 0){
            $cart->delete();
        }

        return response()->json([
            'status' => 'success',
            'quantity'=> $quantity
        ]);
    }
}
