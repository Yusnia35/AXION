<?php

namespace App\Console\Commands;

use App\Models\Analisis;
use App\Models\AnalisisRule;
use App\Models\KelompokAyam;
use App\Models\MonitoringSensor;
use App\Models\PemeriksaanAyam;
use App\Models\Rekomendasi;
use App\Models\Sensor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ClearDummyDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'axion:clear-dummy {--keep-flocks : Pertahankan data kelompok ayam}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus data dummy/simulasi (telemetri sensor, analisis pakar dummy, pemeriksaan dummy) agar sistem bersih untuk data real IoT';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->warn('Memulai pembersihan data dummy AXION...');

        Schema::disableForeignKeyConstraints();

        // 1. Bersihkan rekaman telemetri sensor dummy
        $deletedMonitoring = MonitoringSensor::count();
        MonitoringSensor::truncate();
        $this->info("- Dihapus {$deletedMonitoring} data telemetri sensor dummy.");

        // 2. Bersihkan hasil analisis & rekomendasi dummy
        $deletedAnalisisRule = AnalisisRule::count();
        AnalisisRule::truncate();

        $deletedRekomendasi = Rekomendasi::count();
        Rekomendasi::truncate();

        $deletedAnalisis = Analisis::count();
        Analisis::truncate();
        $this->info("- Dihapus {$deletedAnalisis} data analisis pakar dummy & {$deletedRekomendasi} rekomendasi dummy.");

        // 3. Bersihkan pemeriksaan gejala ayam dummy
        $deletedPemeriksaan = PemeriksaanAyam::count();
        PemeriksaanAyam::truncate();
        $this->info("- Dihapus {$deletedPemeriksaan} data pemeriksaan gejala ayam dummy.");

        // 4. Kelompok ayam (opsional)
        if (! $this->option('keep-flocks')) {
            $deletedFlocks = KelompokAyam::count();
            KelompokAyam::truncate();
            $this->info("- Dihapus {$deletedFlocks} data kelompok ayam dummy.");
        } else {
            $this->comment('- Data kelompok ayam dipertahankan.');
        }

        // 5. Reset status sensor ke offline (menunggu koneksi IoT real)
        Sensor::query()->update([
            'status' => 'offline',
            'last_sync' => null,
        ]);
        $this->info('- Sensor di-reset ke status offline (menunggu telemetri dari mikrokontroler ESP32).');

        Schema::enableForeignKeyConstraints();

        $this->newLine();
        $this->info('Sukses! Seluruh data dummy telah dibersihkan. Sistem AXION siap menerima data REAL dari sensor IoT.');

        return self::SUCCESS;
    }
}
