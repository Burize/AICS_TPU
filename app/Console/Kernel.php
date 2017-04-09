<?php

namespace App\Console;
use App\Models\UserConfirm;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
      //  \App\Console\Commands\Inspire::class,
    ];

  
    protected function schedule(Schedule $schedule)
    {
       $schedule->call(function () {
           UserConfirm::where('updated_at','<',date('Y-m-d H:i:s', strtotime('-1 hours')))->delete();
           User::where('updated_at','<',date('Y-m-d H:i:s', strtotime('-1 hours')))->where('confirm','=',0)->delete();
       })->everyMinute();
    }

  
    
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
