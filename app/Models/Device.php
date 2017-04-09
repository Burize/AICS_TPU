<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Storage as _storage;
class Device extends Model
{
  
    public static function Add(Request $r)
    {
        $device = new Device;
        $device->title=$r->title;
        $device->description=$r->description;
        $device->save();
        
        $photo = $r->file('photo');
        _storage::disk('public')->put('images/'.$device->id,file_get_contents($photo));
        
        return $device;
    }
    
    
    public static function Edit(Request $r)
    {
        $device = Device::find($r->id);
        $device->title=$r->title;
        $device->description=$r->description;
        $device->save();
        if($r->file('photo'))
        {
          $photo = $r->file('photo');
          _storage::disk('public')->put('images/'.$device->id,file_get_contents($photo));
        }
    }
    public function Storage()
    {
        return $this->hasOne('App\Models\Storage','device_id');
    }
}
