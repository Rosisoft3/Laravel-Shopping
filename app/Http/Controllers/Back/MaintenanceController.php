<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MaintenanceController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $active = app()->isDownForMaintenance();
        $ip = $request->ip();
        $message = config('messages.maintenance');
    
        $path = base_path('bootstrap/cache/');        
        $config = file_exists($path . 'config.php');
        $route = file_exists($path . 'routes-v7.php');
    
        return view('back.maintenance.edit', compact('active', 'ip', 'message', 'config', 'route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'ip' => 'required|ip',
            'message' => 'required|string|max:255',
        ]);

        Artisan::call($request->has('active') ? 'down --allow=' . $request->ip . ' --message="' . $request->message . '"' : 'up');

        return back()->withInput()->with('alert', config('messages.maintenanceupdated'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cache(Request $request)
    {
        Artisan::call($request->has('config') ? 'config:cache' : 'config:clear');
        Artisan::call($request->has('route') ? 'route:cache' : 'route:clear');

        $request->session()->flash('alert', config('messages.cacheupdated'));

        return back();
    }
}
