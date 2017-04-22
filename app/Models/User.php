<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends \Eloquent implements Authenticatable
{
    use AuthenticableTrait;
     public function Group()
    {
        return $this->belongsTo('App\Models\Group','group_id','id');
    }
    
  

   
    
    public static function GetUsers()
    {
        return User::where('user_type','!=','admin')->select('id','fio','group_id','user_type')->orderBy('fio')->get();
    }
    
    public static function GetManagers()
    {
        return User::where('user_type','=','manager')->select('id','fio')->orderBy('fio')->get();
    }
    
    public static function UpToManager($id)
    {
        $user = User::find($id);
        $user->user_type = 'manager';
        $user->save();
    }
   
    public static function RemoveFromManagers($id)
    {
        $user = User::find($id);
        $user->user_type = 'user';
        $user->save();
    }
}
