<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RiwayatController extends Controller
{
    /**
     * Display historical analysis log from v_riwayat.
     */
    public function index(): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $riwayats = DB::table('v_riwayat')->latest('dibuat_pada')->get();

        return view('riwayat.index', compact('riwayats', 'currentWorkspace', 'currentUser'));
    }
}
