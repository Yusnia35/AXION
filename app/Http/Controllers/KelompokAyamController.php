<?php

namespace App\Http\Controllers;

use App\Models\KelompokAyam;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KelompokAyamController extends Controller
{
    /**
     * Display chicken flock batches (kelompok ayam).
     */
    public function index(): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $flocks = KelompokAyam::with('kandang')->latest('created_at')->get();

        return view('kelompok-ayam.index', compact('flocks', 'currentWorkspace', 'currentUser'));
    }
}
