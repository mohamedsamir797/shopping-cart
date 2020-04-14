@extends('layouts.app')

@section('content')
   <div class="container">
       @if(session()->has('success'))
           <div class="alert alert-success">{{ session()->get('success') }}</div>
       @endif
       @if($cart)
           <div class="row">
               <div class="col col-7">
               @foreach( $cart->items as $product)
                       <div class="card">
                           <div class="card-body">
                               <h5>{{ $product['title'] }}</h5>
                               <h5 class="card-title">Price : ${{ $product['price'] }}</h5>
                               <div class="row">
                                   <div class="col col-6">
                                       <div class="form-group">
                                           <label>Quantity : </label>
                                           <form action="{{ route('products.update',[$product['id']]) }}" method="post">
                                               @csrf
                                               @method('PUT')
                                               <input type="text" name="qty" id="qty" value="{{ $product['qty'] }}" class="form-control" style="width: 200px;">
                                               <button type="submit" class="btn btn-secondary">Change</button>
                                           </form>
                                       </div>
                                   </div>
                                   <div class="col col-6 mt-5 text-right">
                                       <form action="{{ route('products.destroy',$product['id']) }}" method="post">
                                           @csrf
                                           @method('DELETE')
                                           <button type="submit" class="btn btn-danger ">remove</button>
                                       </form>
                                   </div>
                               </div>


                           </div>
                       </div>
                   @endforeach

               </div>
               <div class="col col-5">
                   <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                       <div class="card-header">Your cart</div>
                       <div class="card-body">
                           <h5 class="card-title">total price : ${{ $cart->totalPrice }}</h5>
                           <h5 class="card-title">total quantity : {{ $cart->totalQty }}</h5>
                           <a href="{{ route('cart.checkout',[ $cart->totalPrice ]) }}" style="background-color: lightskyblue;color: black" class=" btn btn-primary">Checkout</a>
                       </div>
                   </div>
                   <h1>Total : <span class="bg-warning p-1 ">${{ $cart->totalPrice }}</span></h1>

               </div>

           @else
                   <p>there is no item yet</p>
               @endif
           </div>
   </div>
    @endsection