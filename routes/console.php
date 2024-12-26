<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Ustawia tworzenie kopii zapasowych na raz w tygodniu (poniedziałek o godz. 00:00).
Schedule::command('db:backup')->weeklyOn(1, '00:00');
