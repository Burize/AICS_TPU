<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Models\User;
use App\Models\UserConfirm;
use App\Http\Requests;

class Registration extends Controller
{
    public function registration(Request $r)
    {
        $this->validate($r,[
        'name' => 'required|unique:users|max:100',
        'email' => 'required|unique:users|max:250|unique:user_confirm|email',
        'password' => 'required|confirmed|min:6',
        ]);
        $user = new User;
        $user->name=$r->name;
        $user->password=bcrypt($r->password);
        $user->email=$r->email;
        $user->save();
        

        if($user)
        {
            $model = new UserConfirms;
            $model->email=$user->email;
            $model->token=str_random(32);
            $model->save();
            
            Mail::send('emails.confirm',['token'=>$model->token], function($u) use ($user){
                $u->from('demonhost1@gmail.com');
                $u->to($user->email);
                $u->subject('Confirm registration');
            });
            
        }
       //   session()->flash('message','Подтвердите почту: 
//<a href="/registration/confirm/'.$model->token.'">Ссылка</a>');
        return back();
    }
   

    
    
    public function Confirm($token)
    {
        $model=UserConfirm::where('token','=',$token)->firstOrFail(); ///!!!!!!!!!!!!!!!!!!!!!!
        $user = User::where('email','=',$model->email)->first();
        $user->confirm=1;
        $user->save();
        $model->delete();
      return "ok";
    }
    
    public function Index()
    {
        return view('Registration.registration');
    }
}
