<?php

namespace App\Http\Controllers;

use App\Models\ { Address, Country };
use Illuminate\Http\Request;
use App\Http\Requests\StoreAddress;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $addresses = $request->user()->addresses()->with('country')->get();

        if($addresses->isEmpty()) {
            return redirect(route('adresses.create'))->with('message', config('messages.oneaddress'));
        }
        
        return view('account.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();

        return view('account.addresses.create', compact('countries')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAddress $storeAddress
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddress $storeAddress)
    {
        $storeAddress->merge(['professionnal' => $storeAddress->has('professionnal')]);

        $storeAddress->user()->addresses()->create($storeAddress->all());

        return redirect(route('adresses.index'))->with('alert', config('messages.addresssaved'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address $adress
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $adress)
    {
        $this->authorize('manage', $adress);

        $countries = Country::all();

        return view('account.addresses.edit', compact('adress', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreAddress $storeAddress
     * @param  \App\Models\Address $adress
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAddress $storeAddress, Address $adress)
    {
        $this->authorize('manage', $adress);

        $storeAddress->merge(['professionnal' => $storeAddress->has('professionnal')]);

        $adress->update($storeAddress->all());

        return redirect(route('adresses.index'))->with('alert', config('messages.addressupdated')); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address $adress
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $adress)
    {
        $this->authorize('manage', $adress);

        $adress->delete();

        return back()->with('alert', config('messages.addressdeleted'));
    }
}
