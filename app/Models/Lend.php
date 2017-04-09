<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lend extends Model
{ 
    
    
    public function User()
    {
    return $this->belongsTo('App\Models\User','user_id','id');
    }
    
    public function Device()
    {
    return $this->belongsTo('App\Models\Device','device_id','id');
    }
    
    public static function _Return($id)
    {
       $l = Lend::find($id);
        $l->return_at = date('Y-m-d',time());
        $l->save();
        return $l->return_at;
    }
}
