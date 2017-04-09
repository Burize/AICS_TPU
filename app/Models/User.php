<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends \Eloquent implements Authenticatable
{
    use AuthenticableTrait;
    
    public static function Add($group, $fio, $email, $login, $password)
    {
    
        
       $group = mb_strtoupper($group); 
        if(!$group) $group = null;
        $query = User::where('group','=',$group)
            ->where('fio','=',$fio)
            ->first();
        
        if($query)
            return "exist";
        
         $query = User::where('login','=',$login)->first();
        
        if($query)
            return "login";
                             
        $query = User::where('email','=',$email)->first();
        
        if($query)
            return "email";
        
        if(!preg_match("/^[а-яa-z\d][а-яa-z\d]*[а-яa-z\d]$/iu", $password)|| strlen($password)<6)
                       return "password";
        
        $user = new User;
        $user->fio=$fio;
        $user->email = $email;
        $user->login= $login;
        $user->password=password_hash($password,PASSWORD_DEFAULT);
        $user->group = $group;
        $user->save();
        
        return "OK";
                            
    }
    
    public static function UpdateUser($id, $group, $fio, $email, $login, $password)
    {
    
        $user = User::find($id);
         if(!$user) return "err";
         
         
       $group = mb_strtoupper($group);
         if($group != $user->group || $fio != $user->fio)
         {
            if(!$group) $group = null;
            $query = User::where('group','=',$group)
                ->where('fio','=',$fio)
                ->first();

            if($query)
                return "exist";
        
         }
         
           if($login != $user->login)
         {
             $query = User::where('login','=',$login)->first();

            if($query)
                return "login";
         }
         
           if($email != $user->email)
         {
           
        $query = User::where('email','=',$email)->first();
        
        if($query)
            return "email";
         }
         if($password !="")
         {
              if(!preg_match("/^[а-яa-z\d][а-яa-z\d]*[а-яa-z\d]$/iu", $password)|| strlen($password)<6)
                       return "password";
             else
                  $user->password=password_hash($password,PASSWORD_DEFAULT);
         }
       
        
  
        $user->fio=$fio;
        $user->email = $email;
        $user->login= $login;
        $user->group = $group;
        $user->save();
        
        return "OK";
                            
    }
    public static function GetGroups()
    {
        return User::distinct()->where('group','!=','null')->select('group')->orderBy('group')->get();
    }
    public static function GetUser($id)
    {
        $usr = User::find($id);
 
        if(!$usr)
            return 'err';
        else
             return    ['fio' => $usr->fio, 'group' => $usr->group, 'email'=> $usr->email, 'login'=>$usr->login];
        
    }
    
    public static function GetUsers()
    {
        return User::where('user_type','!=','admin')->select('id','fio','group','user_type')->orderBy('fio')->get();
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
