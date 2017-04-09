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
            ->select('cell','lends.id','title','.lends.device_id','fio','user_id','lend_at','lend_to','return_at')
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

    public function _Return(Request$r)
    {
         Storage::Increase($r->_device_id);
      return Lend::_Return($r->_id);
        // return json_encode( Lend::Return($r->id),JSON_UNESCAPED_UNICODE);
    }
}
