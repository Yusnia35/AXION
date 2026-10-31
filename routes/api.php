<?php

use App\Http\Controllers\Api\IotTelemetryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - AXION Smart Poultry Coop IoT Gateway
|--------------------------------------------------------------------------
|
| Endpoint untuk mikrokontroler IoT (ESP32, Arduino, Raspberry Pi)
| dan integrasi telemetri sensor suhu & kelembapan DHT22 / DHT11.
|
*/

Route::prefix('iot')->group(function () {
    // Health check ping
    Route::get('/ping', [IotTelemetryController::class, 'ping'])->name('api.iot.ping');

    // Ingest real sensor telemetry data from ESP32
    Route::post('/telemetry', [IotTelemetryController::class, 'store'])->name('api.iot.telemetry.store');

    // Retrieve latest reading (for AJAX polling on dashboard)
    Route::get('/telemetry/latest', [IotTelemetryController::class, 'latest'])->name('api.iot.telemetry.latest');

    // Retrieve historical telemetry points (for dynamic Chart.js rendering)
    Route::get('/telemetry/history', [IotTelemetryController::class, 'history'])->name('api.iot.telemetry.history');

    // Sensor status list
    Route::get('/sensors', [IotTelemetryController::class, 'sensors'])->name('api.iot.sensors');
});

