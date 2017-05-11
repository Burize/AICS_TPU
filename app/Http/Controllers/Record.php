<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mail;
use App\Http\Requests;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Lend;
use App\Models\Storage;
class Record extends Controller
{
    public function Index()
    {
        $lends = DB::table('lends')
            ->join('users','user_id','=','users.id')
            ->join('devices','lends.device_id','=','devices.id')
            ->join ('storages','storages.device_id','=','devices.id')
            ->join ('groups','users.group_id','=','groups.id')
            ->select('cell','lends.id','devices.title','groups.title AS group','.lends.device_id','fio','user_id','lend_at','lend_to','return_at', 'lend_amount', 'return_amount')
            ->get();
        
        return view( "Record.RecordIndex",['lends'=>$lends]);
    }

    public function Mail(Request $r)
    {  
    $us=User::find($r->id);        
    $name = explode(' ',$us->fio);
    $email = $us->email;
    
         Mail::send('emails.message',['name'=>$name[1],'text'=>$r->text], function($message) use ($r,$email){
                $message->from('demonhost1@gmail.com');
                $message->to($email);
                $message->subject($r->subject);
            });
        return 'ok';
    }

    public function _Return(Request $r)
    {
        
        $l = Lend::find($r->id);
         Storage::Increase($l->device_id, $r->amount);
        Lend::_Return($r->id,$r->amount);
        
        return "OK";
    }
}
