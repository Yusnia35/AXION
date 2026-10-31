<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\MonitoringSensor;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MonitoringController extends Controller
{
    /**
     * Display live temperature & humidity monitoring.
     */
    public function suhu(): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $kandangs = Kandang::with('sensors')->get();
        $monitorings = MonitoringSensor::with(['kandang', 'sensor'])->latest('dicatat_pada')->take(20)->get();
        $latest = MonitoringSensor::latest('dicatat_pada')->first();

        $suhu = $latest ? (float) $latest->suhu : null;
        $kelembapan = $latest ? (float) $latest->kelembapan : null;

        return view('monitoring.suhu', compact(
            'kandangs',
            'monitorings',
            'latest',
            'suhu',
            'kelembapan',
            'currentWorkspace',
            'currentUser'
        ));
    }
}
