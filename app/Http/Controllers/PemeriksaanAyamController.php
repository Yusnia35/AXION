<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\KelompokAyam;
use App\Models\PemeriksaanAyam;
use App\Models\User;
use App\Models\Workspace;
use App\Services\ExpertSystemInferenceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PemeriksaanAyamController extends Controller
{
    /**
     * Display flock clinical health examination logs and metrics.
     */
    public function index(Request $request): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $kelompokAyams = KelompokAyam::with('kandang')->where('is_active', true)->get();
        $kandangs = Kandang::all();

        $query = PemeriksaanAyam::with(['kelompokAyam.kandang', 'user'])->latest('dicatat_pada');

        if ($request->filled('kelompok_id')) {
            $query->where('kelompok_id', $request->input('kelompok_id'));
        }

        if ($request->filled('kandang_id')) {
            $query->whereHas('kelompokAyam', function ($q) use ($request) {
                $q->where('kandang_id', $request->input('kandang_id'));
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'kritis') {
                $query->where(function ($q) {
                    $q->where('kondisi_kotoran', 'berdarah')
                        ->orWhere(function ($q2) {
                            $q2->where('batuk_bersin', 'sering')
                                ->where('nafsu_makan', 'tidak_mau_makan');
                        })
                        ->orWhere('aktivitas', 'sangat_lesu');
                });
            } elseif ($status === 'perlu_pantau') {
                $query->where(function ($q) {
                    $q->where('nafsu_makan', '!=', 'normal')
                        ->orWhere('aktivitas', '!=', 'aktif')
                        ->orWhere('kondisi_mata', '!=', 'normal')
                        ->orWhere('kondisi_bulu', '!=', 'normal')
                        ->orWhere('batuk_bersin', '!=', 'tidak_ada')
                        ->orWhere('kondisi_kotoran', '!=', 'normal');
                })->where(function ($q) {
                    $q->where('kondisi_kotoran', '!=', 'berdarah')
                        ->where('aktivitas', '!=', 'sangat_lesu')
                        ->whereNot(function ($q2) {
                            $q2->where('batuk_bersin', 'sering')
                                ->where('nafsu_makan', 'tidak_mau_makan');
                        });
                });
            } elseif ($status === 'normal') {
                $query->where('nafsu_makan', 'normal')
                    ->where('aktivitas', 'aktif')
                    ->where('kondisi_mata', 'normal')
                    ->where('kondisi_bulu', 'normal')
                    ->where('batuk_bersin', 'tidak_ada')
                    ->where('kondisi_kotoran', 'normal');
            }
        }

        $pemeriksaans = $query->get();

        $allExaminations = PemeriksaanAyam::all();
        $totalPemeriksaan = $allExaminations->count();
        $totalNormal = $allExaminations->filter(fn (PemeriksaanAyam $p) => $p->status_klinis === 'normal')->count();
        $totalPerluPantau = $allExaminations->filter(fn (PemeriksaanAyam $p) => $p->status_klinis === 'perlu_pantau')->count();
        $totalKritis = $allExaminations->filter(fn (PemeriksaanAyam $p) => $p->status_klinis === 'kritis')->count();
        $totalAyamTerpantau = (int) KelompokAyam::where('is_active', true)->sum('jumlah_ayam');

        $showCreateCard = $request->has('tambah');

        return view('pemeriksaan-ayam.index', compact(
            'pemeriksaans',
            'kelompokAyams',
            'kandangs',
            'totalPemeriksaan',
            'totalNormal',
            'totalPerluPantau',
            'totalKritis',
            'totalAyamTerpantau',
            'currentWorkspace',
            'currentUser',
            'showCreateCard'
        ));
    }

    /**
     * Show the form for creating a new examination record.
     */
    public function create(): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $kelompokAyams = KelompokAyam::with('kandang')->where('is_active', true)->get();

        return view('pemeriksaan-ayam.create', compact('kelompokAyams', 'currentWorkspace', 'currentUser'));
    }

    /**
     * Store a newly created examination record in storage.
     */
    public function store(Request $request, ExpertSystemInferenceService $inferenceService): RedirectResponse
    {
        $validated = $request->validate([
            'kelompok_id' => 'required|exists:kelompok_ayam,id',
            'nafsu_makan' => 'required|in:normal,menurun,tidak_mau_makan',
            'aktivitas' => 'required|in:aktif,lesu,sangat_lesu',
            'kondisi_mata' => 'required|in:normal,berair,bengkak',
            'kondisi_bulu' => 'required|in:normal,kusut,rontok',
            'batuk_bersin' => 'required|in:tidak_ada,ringan,sering',
            'kondisi_kotoran' => 'required|in:normal,encer,kehijauan,berdarah',
            'catatan' => 'nullable|string|max:1000',
            'dicatat_pada' => 'nullable|date',
        ]);

        $userId = Auth::id() ?? User::first()?->id ?? 1;

        $pemeriksaan = PemeriksaanAyam::create([
            'kelompok_id' => $validated['kelompok_id'],
            'nafsu_makan' => $validated['nafsu_makan'],
            'aktivitas' => $validated['aktivitas'],
            'kondisi_mata' => $validated['kondisi_mata'],
            'kondisi_bulu' => $validated['kondisi_bulu'],
            'batuk_bersin' => $validated['batuk_bersin'],
            'kondisi_kotoran' => $validated['kondisi_kotoran'],
            'catatan' => $validated['catatan'] ?? null,
            'user_id' => $userId,
            'dicatat_pada' => ! empty($validated['dicatat_pada']) ? $validated['dicatat_pada'] : now(),
        ]);

        $kelompok = KelompokAyam::find($validated['kelompok_id']);
        if ($kelompok && $kelompok->kandang_id) {
            $facts = $inferenceService->gatherFactsForKandang($kelompok->kandang_id, $kelompok->id);
            $facts['nafsu_makan'] = $validated['nafsu_makan'];
            $facts['aktivitas'] = $validated['aktivitas'];
            $facts['kondisi_mata'] = $validated['kondisi_mata'];
            $facts['kondisi_bulu'] = $validated['kondisi_bulu'];
            $facts['batuk_bersin'] = $validated['batuk_bersin'];
            $facts['kondisi_kotoran'] = $validated['kondisi_kotoran'];
            $facts['pemeriksaan_id'] = $pemeriksaan->id;

            $inferenceService->infer(
                facts: $facts,
                kandangId: $kelompok->kandang_id,
                kelompokId: $kelompok->id,
                monitoringId: $facts['monitoring_id'] ?? null,
                kondisiId: $facts['kondisi_id'] ?? null,
                pemeriksaanId: $pemeriksaan->id,
                userId: $userId,
                saveToDatabase: true
            );
        }

        return redirect()->route('pemeriksaan-ayam.index')
            ->with('success', 'Catatan pemeriksaan klinis ayam berhasil disimpan dan dievaluasi oleh sistem pakar!');
    }

    /**
     * Display the specified examination details.
     */
    public function show(PemeriksaanAyam $pemeriksaanAyam): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $pemeriksaanAyam->load(['kelompokAyam.kandang', 'user', 'analisis']);

        return view('pemeriksaan-ayam.show', compact('pemeriksaanAyam', 'currentWorkspace', 'currentUser'));
    }

    /**
     * Show the form for editing the specified examination.
     */
    public function edit(PemeriksaanAyam $pemeriksaanAyam): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $pemeriksaanAyam->load(['kelompokAyam.kandang']);
        $kelompokAyams = KelompokAyam::with('kandang')->get();

        return view('pemeriksaan-ayam.edit', compact('pemeriksaanAyam', 'kelompokAyams', 'currentWorkspace', 'currentUser'));
    }

    /**
     * Update the specified examination in storage.
     */
    public function update(Request $request, PemeriksaanAyam $pemeriksaanAyam): RedirectResponse
    {
        $validated = $request->validate([
            'kelompok_id' => 'required|exists:kelompok_ayam,id',
            'nafsu_makan' => 'required|in:normal,menurun,tidak_mau_makan',
            'aktivitas' => 'required|in:aktif,lesu,sangat_lesu',
            'kondisi_mata' => 'required|in:normal,berair,bengkak',
            'kondisi_bulu' => 'required|in:normal,kusut,rontok',
            'batuk_bersin' => 'required|in:tidak_ada,ringan,sering',
            'kondisi_kotoran' => 'required|in:normal,encer,kehijauan,berdarah',
            'catatan' => 'nullable|string|max:1000',
            'dicatat_pada' => 'nullable|date',
        ]);

        $pemeriksaanAyam->update([
            'kelompok_id' => $validated['kelompok_id'],
            'nafsu_makan' => $validated['nafsu_makan'],
            'aktivitas' => $validated['aktivitas'],
            'kondisi_mata' => $validated['kondisi_mata'],
            'kondisi_bulu' => $validated['kondisi_bulu'],
            'batuk_bersin' => $validated['batuk_bersin'],
            'kondisi_kotoran' => $validated['kondisi_kotoran'],
            'catatan' => $validated['catatan'] ?? null,
            'dicatat_pada' => ! empty($validated['dicatat_pada']) ? $validated['dicatat_pada'] : $pemeriksaanAyam->dicatat_pada,
        ]);

        return redirect()->route('pemeriksaan-ayam.index')
            ->with('success', 'Data pemeriksaan klinis ayam berhasil diperbarui!');
    }

    /**
     * Remove the specified examination from storage.
     */
    public function destroy(PemeriksaanAyam $pemeriksaanAyam): RedirectResponse
    {
        $pemeriksaanAyam->delete();

        return redirect()->route('pemeriksaan-ayam.index')
            ->with('success', 'Data pemeriksaan ayam berhasil dihapus!');
    }
}
