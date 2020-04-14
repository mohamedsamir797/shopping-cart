@extends('layouts.app')

@section('content')
    <div class="container">
        @if( session('success'))
            <div class="alert alert-success">{{ session()->get('success') }}</div>
            @endif
        <div class="row justify-content-center">
            @foreach( $products as $product)
                <div class="col col-3 card m-4" style="width: 18rem;">
                    <img src="{{ $product->image }}" class="card-img-top" >
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <p class="card-text"> on the card title and make up the bulk of the card's content.</p>
                        <p style="font-weight: bold">{{ $product->price }}$</p>
                        <a href="{{ route('cart.add',[ $product->id ]) }}" class="btn btn-primary">Buy</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>


@endsection