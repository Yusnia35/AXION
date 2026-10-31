<?php

namespace App\Http\Controllers;

use App\Models\KondisiLingkungan;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KondisiLingkunganController extends Controller
{
    /**
     * Display environmental conditions (ammonia, litter, noise).
     */
    public function index(): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $kondisis = KondisiLingkungan::with('kandang')->latest('dicatat_pada')->get();

        return view('kondisi-lingkungan.index', compact('kondisis', 'currentWorkspace', 'currentUser'));
    }
}
