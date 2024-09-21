<?php

use App\Console\Commands\SendNotifications;
use \Illuminate\Support\Facades\Schedule;

Schedule::command(SendNotifications::class)->everyMinute();

