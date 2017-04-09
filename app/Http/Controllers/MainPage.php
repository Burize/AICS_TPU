<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class MainPage extends Controller
{
public function Index()
    {
    $devices = DB::table('devices')
           ->join('storages','devices.id','=','storages.device_id')
           ->get();
    
  
    return view("MainPage.main",['devices'=>$devices]);
    }
}
