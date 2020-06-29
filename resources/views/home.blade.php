@extends('layouts.app')

@section('content')
<div class="container">

  <div class="row">     
    <div class="card">
      <div class="card-content">
      <span class="card-title center-align">{{ $shop->home }}</span>
        <br>
        <ul class="collapsible">
          <li>
            <div class="collapsible-header"><i class="material-icons">info</i>Informations générales</div>
            <div class="collapsible-body informations">
              <ul>
                <li>{{ $shop->home_infos }}</li>
              </ul>
            </div>
          </li>
          <li>
            <div class="collapsible-header"><i class="material-icons">local_shipping</i>Frais d'expédition</div>
            <div class="collapsible-body informations">
              <ul>
                <li>{{ $shop->home_shipping }}</li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col s12 cards-container">
      @foreach($products as $product)
        <div class="card">
          <div class="card-image">
            @if($product->quantity)
              <a href="{{ route('produits.show', $product->id) }}">
            @endif
              <img src="/images/thumbs/{{ $product->image }}">
            @if($product->quantity) </a> @endif
          </div>          
          <div class="card-content center-align">
            <p>{{ $product->name }}</p>
            @if($product->quantity)
              <p><strong>{{ number_format($product->price, 2, ',', ' ') }} € TTC</strong></p>
            @else
              <p class="red-text"><strong>Produit en rupture de stock</strong></p>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>

</div>
@endsection
