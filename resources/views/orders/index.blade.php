@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session()->has('success'))
            <div class="alert alert-success">{{ session()->get('success') }}</div>
        @endif
        @foreach( $carts as $cart)w
            <div class="row">
                 <div class="col col-9 ">
                     <div class="card">
                             <table class="table table-striped">
                                 <tr>
                                     <th>title</th>
                                     <th>price</th>
                                     <th>Quantity</th>
                                     <th>paid</th>
                                 </tr>
                                 @foreach( $cart->items as $item )
                                 <tr>
                                     <td>{{ $item['title'] }}</td>
                                     <td>${{ $item['price'] }}</td>
                                     <td>{{ $item['qty'] }}</td>
                                     <td>paid</td>
                                 </tr>
                                 @endforeach

                             </table>
                     </div>
                     <p class="badge-pill bg-primary btn text-white mt-3">Total Price : ${{ $cart->totalPrice }}</p>

                 </div>
            </div>
            @endforeach
    </div>

    @endsection