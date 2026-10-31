<?php

use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\KelompokAyamController;
use App\Http\Controllers\KondisiLingkunganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\PemeriksaanAyamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\UserController;
use App\Models\Analisis;
use App\Models\Kandang;
use App\Models\KelompokAyam;
use App\Models\MonitoringSensor;
use App\Models\Rekomendasi;
use App\Models\Rule;
use App\Models\Sensor;
use App\Models\User;
use App\Models\Workspace;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Public Landing Page (Profil Web Sistem Pakar & Keunggulan AXION)
Route::get('/', function () {
    $rules = Rule::with(['ruleKondisis', 'tindakanRules'])->where('is_active', true)->get();
    $kandangs = Kandang::with('kelompokAyams')->get();
    $totalAyam = KelompokAyam::where('is_active', true)->sum('jumlah_ayam');
    $rulesCount = Rule::count();
    $sensorsCount = Sensor::count();

    $latestMonitoring = MonitoringSensor::latest('dicatat_pada')->first();
    $suhu = $latestMonitoring ? (float) $latestMonitoring->suhu : 32.5;
    $kelembapan = $latestMonitoring ? (float) $latestMonitoring->kelembapan : 76.0;

    return view('landing', compact(
        'rules',
        'kandangs',
        'totalAyam',
        'rulesCount',
        'sensorsCount',
        'suhu',
        'kelembapan'
    ));
})->name('landing');

Route::get('/landing', function () {
    return redirect()->route('landing');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Sistem AXION)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $currentUser = Auth::user() ?? User::where('role', 'farm_manager')->first() ?? User::first();
        $currentWorkspace = $currentUser->workspace ?? Workspace::first();

        $kandangs = Kandang::with(['kelompokAyams', 'sensors'])->get();
        $sensors = Sensor::all();
        $totalAyam = KelompokAyam::where('is_active', true)->sum('jumlah_ayam');
        $activeFlocksCount = KelompokAyam::where('is_active', true)->count();
        $rules = Rule::where('is_active', true)->get();
        $rulesCount = Rule::count();
        $riwayats = DB::table('v_riwayat')->latest('dibuat_pada')->take(5)->get();

        // Real Telemetry Data from IoT
        $latestMonitoring = MonitoringSensor::latest('dicatat_pada')->first();
        $suhu = $latestMonitoring ? (float) $latestMonitoring->suhu : null;
        $kelembapan = $latestMonitoring ? (float) $latestMonitoring->kelembapan : null;

        // Real Latest Analysis from Expert System
        $latestAnalisis = Analisis::with(['kandang', 'kelompokAyam'])->latest('dibuat_pada')->first();

        // Real Pending Recommendations
        $rekomendasis = Rekomendasi::where('status', 'pending')->latest('dibuat_pada')->take(3)->get();

        // Real Historical Telemetry Trend for Chart.js
        $telemetriHistory = MonitoringSensor::latest('dicatat_pada')->take(14)->get()->reverse()->values();
        $chartLabels = $telemetriHistory->map(fn ($item) => Carbon::parse($item->dicatat_pada)->format('H:i'))->values();
        $chartSuhu = $telemetriHistory->pluck('suhu')->map(fn ($val) => (float) $val)->values();
        $chartKelembapan = $telemetriHistory->pluck('kelembapan')->map(fn ($val) => (float) $val)->values();

        return view('dashboard', compact(
            'currentWorkspace',
            'currentUser',
            'kandangs',
            'sensors',
            'totalAyam',
            'activeFlocksCount',
            'rules',
            'rulesCount',
            'riwayats',
            'latestMonitoring',
            'suhu',
            'kelembapan',
            'latestAnalisis',
            'rekomendasis',
            'chartLabels',
            'chartSuhu',
            'chartKelembapan'
        ));
    })->name('dashboard');

    // Menu Kandang Saya
    Route::resource('kandang', KandangController::class);

    // Menu Kandang & Sensor
    Route::get('/sensor', [SensorController::class, 'index'])->name('sensor.index');
    Route::post('/sensor/clear-dummy', [SensorController::class, 'clearDummyData'])->name('sensor.clearDummy');
    Route::get('/monitoring-suhu', [MonitoringController::class, 'suhu'])->name('monitoring.suhu');
    Route::get('/kondisi-lingkungan', [KondisiLingkunganController::class, 'index'])->name('kondisi-lingkungan.index');

    // Menu Data & Kesehatan Ayam
    Route::get('/kelompok-ayam', [KelompokAyamController::class, 'index'])->name('kelompok-ayam.index');
    Route::resource('pemeriksaan-ayam', PemeriksaanAyamController::class);

    // Menu Sistem Pakar (Forward Chaining)
    Route::get('/basis-rules', [RuleController::class, 'index'])->name('rules.index');
    Route::get('/hasil-analisis', [AnalisisController::class, 'index'])->name('analisis.index');
    Route::post('/hasil-analisis/diagnosa', [AnalisisController::class, 'diagnosa'])->name('analisis.diagnosa');
    Route::get('/hasil-analisis/{analisis}', [AnalisisController::class, 'show'])->name('analisis.show');
    Route::get('/rekomendasi-tindakan', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
    Route::patch('/rekomendasi-tindakan/{rekomendasi}/status', [RekomendasiController::class, 'updateStatus'])->name('rekomendasi.updateStatus');

    // Menu Riwayat & Laporan
    Route::get('/riwayat-analisis', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/laporan-ekspor', [LaporanController::class, 'index'])->name('laporan.index');

    // Profil Pengguna & Edit Foto
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil/foto', [ProfileController::class, 'destroyPhoto'])->name('profile.foto.destroy');

    // Menu Khusus Administrator: Manajemen User (Protected by Admin Middleware)
    Route::middleware('admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    });
});
