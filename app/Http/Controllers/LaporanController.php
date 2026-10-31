<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Models\Kandang;
use App\Models\KelompokAyam;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /**
     * Display reports & export dashboard.
     */
    public function index(): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $kandangs = Kandang::with(['kelompokAyams', 'analisis'])->get();
        $totalAyam = KelompokAyam::where('is_active', true)->sum('jumlah_ayam');
        $totalAnalisis = Analisis::count();

        return view('laporan.index', compact(
            'kandangs',
            'totalAyam',
            'totalAnalisis',
            'currentWorkspace',
            'currentUser'
        ));
    }
}
