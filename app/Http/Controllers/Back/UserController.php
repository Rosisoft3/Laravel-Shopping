<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\DataTables\UsersDataTable  $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
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
        $user = User::with('orders', 'orders.state', 'addresses')->findOrFail($id);

        return view('back.users.show', compact('user'));
    }
}
