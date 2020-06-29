<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use App\DataTables\AddressesDataTable;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\DataTables\AddressesDataTable;  $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(AddressesDataTable $dataTable)
    {
        return $dataTable->render('back.shared.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = Address::findOrFail($id);

        return view('back.addresses.show', compact('address'));
    }
 
}
