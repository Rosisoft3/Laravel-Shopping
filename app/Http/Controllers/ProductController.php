<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Product $produit)
    {
        if($produit->active || $request->user()->admin) {
            return view('products.show', compact('produit'));
        }

        return redirect(route('home'));
    }
}