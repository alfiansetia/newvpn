<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:monitor-expired-vpn')->dailyAt('13:00')->onSuccess(function () {
    Log::info('Cronjob Monitor VPN berhasil dijalankan');
})->onFailure(function () {
    Log::error('Cronjob Monitor VPN Gagal dijalankan');
});

Schedule::command('database:backup')->dailyAt('01:00')->onSuccess(function () {
    Log::info('Cronjob Backup Database berhasil dijalankan');
})->onFailure(function () {
    Log::error('Cronjob Backup Database Gagal dijalankan');
});
