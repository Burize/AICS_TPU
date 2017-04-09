<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        return User::GetUser($r->id);
    }
    
    public function GetUsers()
    {
        $students =[ User::GetGroups()]; 
        array_push($students, User::GetUsers());
  
        
        return json_encode($students,JSON_UNESCAPED_UNICODE);
    }

    public function GetManagers()
    {          
        return json_encode(User::GetManagers(),JSON_UNESCAPED_UNICODE);
    }
    
    public function AddUser(Request $r)
    {
        return User::Add($r->group, $r->fio, $r->email, $r->login, $r->password);
    }
    
    public function UpdateUser(Request $r)
    {
      
         return User::UpdateUser($r->id,$r->group, $r->fio, $r->email, $r->login, $r->password);
    }
    
    public function DeleteUser(Request $r)
    {
  
        User::destroy($r->id);
          
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
