<?php

namespace App\Http\Controllers;
use App\Models\Device;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\User;
use App\Models\Lend;
use Storage as _storage;

class DeviceManager extends Controller
{
    
    
    public function Add(Request $r)
    {
        if($r->isMethod('get'))
       {
           return view('DeviceManager.add_index');
       }
        else
        {
           
        $this->validate($r,[
            'title'=>'required|max:100',
            'description'=>'required|max:3000',
         'photo'=>'required|image|mimes:jpeg,png',
            'amount'=>'required|min:0|numeric',
            'cell' => 'required|min:0',
        ]);
        
        $device=Device::Add($r);
        $storage = Storage::Add($r);
        $device->Storage()->save($storage);
           
        return redirect()->route('main');
       }
    }
    
    public function ItemIndex(Request $r)
    {
         $device = DB::table('devices')
           ->where('id','=',$r->id)
           ->join('storages','devices.id','=','storages.device_id')
           ->first();
    
    return view("DeviceManager.item_index",['device'=>$device]);
    }
    
   
    
    public function Edit(Request $r)
    {
       if($r->isMethod('get'))
       {
          $device = DB::table('devices')
           ->where('id','=',$r->id)
           ->join('storages','devices.id','=','storages.device_id')
           ->first();

    return view("DeviceManager.item_edit",['device'=>$device]);  
       }
        else
       {
        $this->validate($r,[
            'title'=>'required|max:100',
            'description'=>'required|max:3000',
         'photo'=>'image|mimes:jpeg,png',
            'amount'=>'required|min:0|numeric',
            'cell' => 'required|min:0',
        ]);
        
        Device::Edit($r);
        Storage::Edit($r);
        return redirect()->route('main');
       }
    }
    
    
  
    
    public function Lend( Request $r)
    {
         if($r->isMethod('get'))
       {
            $device = DB::table('devices')
           ->where('id','=',$r->id)
           ->join('storages','devices.id','=','storages.device_id')
           ->first();
        
       return view("DeviceManager.item_lend",['title'=>$device->title, 'amount'=>$device->amount, 'cell'=>$device->cell]);       }
        else
       {
            $amount = Storage::Amount($r->device_id);
        $this->validate($r,[
            'lend_at'=>'required|date|before:lend_to',
            'lend_to'=>'required|date',
            'user_id'=>'required|numeric|min:0',
            'device_id'=>'required|numeric|min:0',
            'amount'=>'required|min:1|numeric|max:{$amount}',
        ]);
        
        
        $lend = new Lend;
        $lend->lend_at = $r->lend_at;
        $lend->lend_to = $r->lend_to;
        $lend->lend_amount = $r->amount;
        $lend->Device()->associate(Device::find($r->device_id));
        $lend->User()->associate(User::find($r->user_id));
        $lend->save();
        
        Storage::Reduce($r->device_id,$r->amount);
       
        return redirect()->route('main');
        }
       
    }
    
   
    
    public function Delete(Request $r)
    {
        _storage::disk('public')->delete('images/'.$r->id);
        Storage::_Delete($r->id);
        Device::destroy($r->id);
        return "ok";
    }
}
