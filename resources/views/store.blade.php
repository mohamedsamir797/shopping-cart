@extends('layouts.app')

@section('content')

    <div class="container">
        @if(session()->has('success'))
            <div class="alert alert-success">{{ session()->get('success') }}</div>
            @endif
       <div class="section">
           <div class="jumbotron">
               <h1 class="display-4">Hello, world!</h1>
               <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
               <hr class="my-4">
               <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
               <a class="btn btn-primary btn-lg" href="{{ route('products.index') }}" role="button">Learn more</a>
           </div>
       </div>
            <div class="row">
                @foreach( $products as $product)
                    <div class="col col-4 card" style="width: 18rem;">
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