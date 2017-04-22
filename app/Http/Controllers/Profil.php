<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Http\Requests;
use Illuminate\Http\Response;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class Profil extends Controller
{

	public function Index()   
    {
      $lends = DB::table('lends')
            ->join('users','user_id','=','users.id')
            ->join('devices','device_id','=','devices.id')
            ->where('users.id','=',Auth::user()->id)
            ->select('title','device_id','lend_at','lend_to','return_at')
            ->get();
        
        return view( "Profil.Index",['lends'=>$lends]);
    

    }

    
     public function Login(Request $r)
    {
            if($r->isMethod('get'))
            {
                return view("Profil.login");
            }
        else
            {
                if( Auth::attempt(['login' => $r->login,'password'=>$r->password]) )
                {
                    return "OK";
               }
                else
               return "invalid";   

            }
               
    }
    
    public function Logout()
    {
        Auth::logout();
        return back();
    }
    
    public function Admin()
    {
        return view("Profil.Admin");
    }

    public function GetUser( Request $r)
    {
         $usr = User::find($r->id);
 
        if(!$usr)
            return 'err';
        if($usr->group_id)
            $group =  Group::find($usr->group_id)->title;
        else
            $group = null;
        
       return ['fio' => $usr->fio, 'group' => $group, 'email'=> $usr->email, 'login'=>$usr->login];
    }
    
    public function GetUsers()
    {
        $students =[Group::Get() ]; 
        
        array_push($students, User::GetUsers());
  
        
        return json_encode($students,JSON_UNESCAPED_UNICODE);
    }

    public function GetManagers()
    {          
        return json_encode(User::GetManagers(),JSON_UNESCAPED_UNICODE);
    }
    
    public function AddUser(Request $r)
    {
        $group = mb_strtoupper($r->group); 
        
        if($group == "") $group_id = null;
        else
        {
            $group_id = Group::where('title','=',$group)->select('id')->first();
            if($group_id)
                $group_id = $group_id->id;
        }
       
        $query = User::where('group_id','=',$group_id)
            ->where('fio','=',$r->fio)
            ->first();
        
       
        
        if($query)
            return "exist";
        
         $query = User::where('login','=',$r->login)->first();
        
        if($query)
            return "login";
                             
        $query = User::where('email','=',$r->email)->first();
        
        if($query)
            return "email";
        
        if(!preg_match("/^[а-яa-z\d][а-яa-z\d]*[а-яa-z\d]$/iu", $r->password)|| strlen($r->password)<6)
                       return "password";
        
        if($group_id == null && $group != null )
        {
            $g = new  Group;
            $g->title = $group;
            $g->save();
            $group_id = Group::where('title','=',$group)->select('id')->first()->id;
        }
        
        $user = new User;
        $user->fio=$r->fio;
        $user->email = $r->email;
        $user->login= $r->login;
        $user->password=password_hash($r->password,PASSWORD_DEFAULT);
        if($group_id == null)
            $user->group_id = null;
        else
             $user->Group()->associate(Group::where('title','=',$group)->first() );
        $user->save();
        
        return "OK";
    }
    
    public function UpdateUser(Request $r)
    {
      
          $user = User::find($r->id);
         if(!$user) return "err";
         
         
       $group = mb_strtoupper($r->group);
       $exist = Group::where('title','=',$group)->first();
        if($exist)
            $group_id = $exist->id;
        else
             $group_id = null;
        if($exist)
         if($group_id != $user->group_id || $r->fio != $user->fio)
         {
           
            $query = User::where('group_id','=',$group_id)
                ->where('fio','=',$r->fio)
                ->first();

            if($query)
                return "exist";
        
         }
         
           if($r->login != $user->login)
         {
             $query = User::where('login','=',$r->login)->first();

            if($query)
                return "login";
         }
         
           if($r->email != $user->email)
         {
           
        $query = User::where('email','=',$r->email)->first();
        
        if($query)
            return "email";
         }
         if($r->password !="")
         {
              if(!preg_match("/^[а-яa-z\d][а-яa-z\d]*[а-яa-z\d]$/iu", $r->password)|| strlen($r->password)<6)
                       return "password";
             else
                  $user->password=password_hash($r->password,PASSWORD_DEFAULT);
         }
       
         if($group_id == null && $group != null )
        {
            $g = new  Group;
            $g->title = $group;
            $g->save();
        }
  
        $user->fio = $r->fio;
        $user->email = $r->email;
        $user->login = $r->login;
     
    
        $old_group =  $user->group_id;
        
        if($group_id == null)
            $user->group_id = null;
        else
             $user->Group()->associate(Group::where('title','=',$group)->first() );
        $user->save();
        
        
        
          if(!User::where('group_id','=',$old_group)->first() && $old_group)  
           Group::destroy($old_group);
        
        return "OK";
    }
    
    public function DeleteUser(Request $r)
    {
  
        $group_id = User::find($r->id)->group_id;
        
        User::destroy($r->id);
        
           
        if(!User::where('group_id','=',$group_id)->first() && $group_id)  
           Group::destroy($group_id);
        
        if(User::find($r->id))
            return "err";
        else
            return "OK";
    }
    
    public function AddManager(Request $r)
    {
        User::UpToManager($r->user_id);
        return back();
    }
    
    public function RemoveFromManagers(Request $r)
    {
        User::RemoveFromManagers($r->user_id);
        return back();
    }
}
