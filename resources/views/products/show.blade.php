@extends('layouts.app')

@section('content')
<div class="container">

  @if(session()->has('cart'))
    <div class="modal">
      <div class="modal-content center-align">
        <h5>Produit ajouté au panier avec succès</h5>
        <hr>
        <p>Il y a {{ $cartCount }} @if($cartCount > 1) articles @else article @endif dans votre panier pour un total de <strong>{{ number_format($cartTotal, 2, ',', ' ') }} € TTC</strong> hors frais de port.</p>
        <p><em>Vous avez la possibilité de venir chercher vos produits sur place, dans ce cas vous cocherez la case correspondante lors de la confirmation de votre commande et aucun frais de port ne vous sera facturé.</em></p>
        <div class="modal-footer">     
          <button class="modal-close btn waves-effect waves-light left" id="continue">
            Continuer mes achats
          </button>
          <a href="{{ route('panier.index') }}" class="btn waves-effect waves-light">
            <i class="material-icons left">check</i>
            Commander          
          </a>
        </div>
      </div>
    </div>
  @endif

  <div class=row>
    <div class="col s12 m6">
      <img style="width: 100%" src="/images/{{ $produit->image }}">
    </div>
    <div class="col s12 m6">
      <h4>{{ $produit->name }}</h4>
      <p><strong>{{ number_format($produit->price, 2, ',', ' ') }} € TTC</strong></p>
      <p>{{ $produit->description }}</p>
      <form  method="POST" action="{{ route('panier.store') }}">
        @csrf
        <div class="input-field col">
          <input type="hidden" id="id" name="id" value="{{ $produit->id }}">
          <input id="quantity" name="quantity" type="number" value="1" min="1">
          <label for="quantity">Quantité</label>        
          <p>
            <button class="btn waves-effect waves-light" style="width:100%" type="submit" id="addcart">Ajouter au panier
              <i class="material-icons left">add_shopping_cart</i>
            </button>
          </p>    
        </div>    
      </form>
    </div>
  </div>

</div>
@endsection

@section('javascript')
  <script>
    @if(session()->has('cart'))
      document.addEventListener('DOMContentLoaded', () => {      
        const instance = M.Modal.init(document.querySelector('.modal'));
        instance.open();    
      });
    @endif    
  </script>
@endsection
