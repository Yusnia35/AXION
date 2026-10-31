<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Models\Kandang;
use App\Models\KelompokAyam;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KandangController extends Controller
{
    /**
     * Display a listing of all farm houses (kandang).
     */
    public function index(Request $request): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();

        $kandangs = Kandang::with(['kelompokAyams', 'latestAnalisis'])
            ->where('workspace_id', $currentWorkspace->id ?? 1)
            ->get();

        $totalKandang = $kandangs->count();
        $totalKapasitas = (int) $kandangs->sum('kapasitas');
        $totalPopulasi = (int) $kandangs->sum(fn (Kandang $k) => $k->total_ayam);
        $avgHealthScore = $totalKandang > 0 ? (int) round($kandangs->avg(fn (Kandang $k) => $k->health_score)) : 85;
        $showCreateCard = $request->has('tambah');

        return view('kandang.index', compact(
            'kandangs',
            'totalKandang',
            'totalKapasitas',
            'totalPopulasi',
            'avgHealthScore',
            'currentWorkspace',
            'currentUser',
            'showCreateCard'
        ));
    }

    /**
     * Show the form for creating a new kandang.
     */
    public function create(): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();

        return view('kandang.create', compact('currentWorkspace', 'currentUser'));
    }

    /**
     * Store a newly created kandang in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('jenis_kandang')) {
            $parts = explode('|', (string) $request->input('jenis_kandang'));
            $request->merge([
                'jenis_ayam' => $parts[0] ?? 'Broiler',
                'tipe_kandang' => $parts[1] ?? 'open_house',
            ]);
        }

        if ($request->filled('jumlah_ayam') && ! $request->filled('populasi_awal')) {
            $request->merge([
                'populasi_awal' => $request->input('jumlah_ayam'),
            ]);
        }

        $workspace = Workspace::first();
        $workspaceId = $workspace?->id ?? 1;

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:50',
                'unique:kandang,nama,NULL,id,workspace_id,'.$workspaceId,
            ],
            'jenis_ayam' => ['required', 'string', 'max:30'],
            'tipe_kandang' => ['required', 'in:open_house,closed_house'],
            'lokasi' => ['nullable', 'string', 'max:100'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'populasi_awal' => ['nullable', 'integer', 'min:0'],
        ]);

        $kandang = Kandang::create([
            'workspace_id' => $workspaceId,
            'nama' => $validated['nama'],
            'jenis_ayam' => $validated['jenis_ayam'],
            'tipe_kandang' => $validated['tipe_kandang'],
            'lokasi' => $validated['lokasi'],
            'kapasitas' => (int) $validated['kapasitas'],
        ]);

        if (! empty($validated['populasi_awal']) && (int) $validated['populasi_awal'] > 0) {
            $kodeKelompok = 'FLOCK-'.strtoupper(substr(str_replace(' ', '', $kandang->nama), 0, 6)).'-'.date('ymd-His');
            KelompokAyam::create([
                'kandang_id' => $kandang->id,
                'kode' => $kodeKelompok,
                'jumlah_ayam' => (int) $validated['populasi_awal'],
                'tanggal_masuk' => now()->toDateString(),
                'profil' => 'Campuran',
                'is_active' => true,
            ]);
        }

        Analisis::create([
            'kandang_id' => $kandang->id,
            'health_score' => 88,
            'level_risiko' => 'rendah',
            'status_kandang' => 'normal',
            'ringkasan' => 'Kandang baru berhasil didaftarkan ke sistem AXION. Kondisi mikroklimat awal terpantau normal.',
            'user_id' => $workspaceId,
            'dibuat_pada' => now(),
        ]);

        return redirect()->route('kandang.index')->with('success', 'Kandang '.$kandang->nama.' berhasil ditambahkan!');
    }

    /**
     * Show the specified kandang.
     */
    public function show(Kandang $kandang): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();
        $kandang->load(['kelompokAyams', 'latestAnalisis', 'sensors']);

        return view('kandang.show', compact('kandang', 'currentWorkspace', 'currentUser'));
    }

    /**
     * Show the form for editing the specified kandang.
     */
    public function edit(Kandang $kandang): View
    {
        $currentWorkspace = Workspace::first();
        $currentUser = Auth::user() ?? User::first();

        return view('kandang.edit', compact('kandang', 'currentWorkspace', 'currentUser'));
    }

    /**
     * Update the specified kandang in storage.
     */
    public function update(Request $request, Kandang $kandang): RedirectResponse
    {
        $workspaceId = $kandang->workspace_id;

        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:50',
                'unique:kandang,nama,'.$kandang->id.',id,workspace_id,'.$workspaceId,
            ],
            'jenis_ayam' => ['required', 'string', 'max:30'],
            'tipe_kandang' => ['required', 'in:open_house,closed_house'],
            'lokasi' => ['nullable', 'string', 'max:100'],
            'kapasitas' => ['required', 'integer', 'min:1'],
        ]);

        $kandang->update($validated);

        return redirect()->route('kandang.index')->with('success', 'Data kandang '.$kandang->nama.' berhasil diperbarui!');
    }

    /**
     * Remove the specified kandang from storage.
     */
    public function destroy(Kandang $kandang): RedirectResponse
    {
        $nama = $kandang->nama;
        $kandang->delete();

        return redirect()->route('kandang.index')->with('success', 'Kandang '.$nama.' berhasil dihapus!');
    }
}
