<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Administration
Route::prefix('admin')->middleware('admin')->namespace('Back')->group(function () {
    Route::name('admin')->get('/', 'AdminController@index');
    Route::name('read')->put('read/{type}', 'AdminController@read');
    
    Route::name('shop.edit')->get('boutique', 'ShopController@edit');
    Route::name('shop.update')->put('boutique', 'ShopController@update');
});

// Accueil boutique et panier
Route::get('/', 'HomeController@index')->name('home');
Route::name('produits.show')->get('produits/{produit}', 'ProductController');
Route::resource('panier', 'CartController')->only(['index', 'store', 'update', 'destroy']);

Route::post('deconnexion', 'Auth\LoginController@logout')->name('logout');
Route::middleware('guest')->group(function () {
    Route::prefix('connexion')->group(function () {
        Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('/', 'Auth\LoginController@login');
    });
    Route::prefix('inscription')->group(function () {
        Route::get('/', 'Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('/', 'Auth\RegisterController@register');
    });
});
Route::prefix('passe')->group(function () {
    Route::get('renouvellement', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('renouvellement/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('renouvellement', 'Auth\ResetPasswordController@reset')->name('password.update');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('page/{page:slug}', 'HomeController@page')->name('page');

// Utilisateur authentifié
Route::middleware('auth')->group(function () {
    // Gestion du compte
    Route::prefix('compte')->group(function () {
        Route::name('account')->get('/', 'AccountController');
        Route::name('identite.edit')->get('identite', 'IdentiteController@edit');
        Route::name('identite.update')->put('identite', 'IdentiteController@update');
        Route::name('rgpd')->get('rgpd', 'IdentiteController@rgpd');
        Route::name('rgpd.pdf')->get('rgpd/pdf', 'IdentiteController@pdf');
        Route::resource('adresses', 'AddressController')->except('show');
        Route::resource('commandes', 'OrdersController')->only(['index', 'show'])->parameters(['commandes' => 'order']);
        Route::name('invoice')->get('commandes/{order}/invoice', 'InvoiceController');
    });
    // Commandes
    Route::prefix('commandes')->group(function () {
        Route::name('commandes.details')->post('details', 'DetailsController');
        Route::name('commandes.confirmation')->get('confirmation/{order}', 'OrdersController@confirmation');
        Route::resource('/', 'OrderController')->names([
            'create' => 'commandes.create',
            'store' => 'commandes.store',
        ])->only(['create', 'store']);
        Route::name('commandes.payment')->post('paiement/{order}', 'PaymentController');
    });
});
