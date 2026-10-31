<?php

namespace App\Http\Controllers;

use App\Models\Rekomendasi;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RekomendasiController extends Controller
{
    /**
     * Display expert recommendations.
     */
    public function index(): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $rekomendasis = Rekomendasi::with(['analisis.kandang', 'rule'])->latest('dibuat_pada')->get();

        return view('rekomendasi.index', compact('rekomendasis', 'currentWorkspace', 'currentUser'));
    }

    /**
     * Update the progress status of a recommendation action.
     */
    public function updateStatus(Request $request, Rekomendasi $rekomendasi): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:baru,in_progress,selesai',
        ]);

        $rekomendasi->status = $validated['status'];
        if ($validated['status'] === 'selesai') {
            $rekomendasi->selesai_pada = now();
        } else {
            $rekomendasi->selesai_pada = null;
        }
        $rekomendasi->save();

        return redirect()->route('rekomendasi.index')
            ->with('success', 'Status tindakan rekomendasi berhasil diperbarui menjadi '.ucfirst(str_replace('_', ' ', $validated['status'])).'!');
    }
}
