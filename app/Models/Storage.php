<?php

namespace App\Models;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    public $primaryKey  = 'device_id';
    
    public static function Add(Request $r)
    {
        $storage = new Storage;
        $storage->amount=$r->amount;
        $storage->cell=$r->cell; 
        return $storage;
    }
    
    public static function Edit(Request $r)
    {
        $storage = Storage::where('device_id',$r->id)
            ->update(['amount' => $r->amount, 'cell' => $r->cell]);
    
    }
    
    public static function Amount( $id)
    {
        return Storage::where('device_id',$id)->select('amount')->first();
    }
    
    public static function Reduce( $id,  $number)
    {
        $device = Storage::where('device_id',$id)->first();
        $device->amount=  $device->amount - $number;
        $device->save();
    }
    
      public static function Increase($id )
    {
        $device = Storage::where('device_id',$id)->first();
        $device->amount=  $device->amount + 1;
        $device->save();
    }
    
    public function Devices()
    {
        return $this->hasOne('App\Models\Device','id','device_id');
    }
    
    public static function _Delete($id)
    {
        Storage::where('device_id','=',$id)->delete();
        
    }
}
