<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use App\Product;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session('success')){
            toast(session('success'),'success');
        }
        $products = Product::all();
        return view('products.index',compact('products'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'qty' => 'required|numeric|min:1'
        ]);

        $cart = new Cart(session()->get('cart'));
        $cart->updateQty($product->id,$request->qty);
        session()->put('cart',$cart);
        return redirect()->back()->with('success','quantity updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
       $cart = new Cart(session()->get('cart'));
       $cart->remove($product->id);

       if ( $cart->totalQty <= 0 ){
           session()->forget('cart');
       }else {
           session()->put('cart',$cart);
       }
       return redirect()->back()->with('success','product deleted successfully');
    }

    public function addToCart(Product $product){
        if (session()->has('cart')){
            $cart = new Cart(session()->get('cart'));
        }else{
            $cart = new Cart();
        }
        $cart->add($product);
        //dd($cart);
        session()->put('cart',$cart);
        return redirect()->back()->with('success','product added successfully ');
    }
    public function showCart(){
        if (session('success')){
            toast(session('success'),'success');
        }
        if (session()->has('cart')){
            $cart = new Cart(session()->get('cart'));
        }else {
            $cart = null ;
        }
        return view('cart.show',compact('cart'));
    }
    public function checkout($amount){

        return view('cart.checkout',compact('amount'));
    }
    public function charge(Request $request){
      $charge = Stripe::charges()->create([
        'currency' => 'USD',
          'source' => $request->stripeToken ,
          'amount' => $request->amount ,
          'description' => 'test from laravel new app'
      ]);
      $chargeId = $charge['id'];

      if ($chargeId){
          //save order in orders table
          auth()->user()->orders()->create([
              'cart' => serialize(session()->get('cart'))
          ]);
          session()->forget('cart');
          return redirect()->route('store')->with('success','payment is done Thanks');
      }else {
         return back();
      }
    }
    public function allOrders(){
         $orders = auth()->user()->orders ;
         $carts = $orders->transform( function ($cart , $key){
             return unserialize($cart->cart);
         });
        return view('orders.index',compact('carts'));
    }
}
