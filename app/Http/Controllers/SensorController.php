<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SensorController extends Controller
{
    /**
     * Display listing of IoT sensors.
     */
    public function index(): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $sensors = Sensor::with('kandang')->get();

        return view('sensor.index', compact('sensors', 'currentWorkspace', 'currentUser'));
    }

    /**
     * Purge all dummy simulation data so system operates purely with real IoT data.
     */
    public function clearDummyData(): RedirectResponse
    {
        Artisan::call('axion:clear-dummy');

        return redirect()->back()->with('success', 'Seluruh data dummy telemetri dan analisis berhasil dibersihkan! Sistem AXION kini beroperasi penuh dengan data REAL.');
    }
}
