<?php

namespace App\Http\Controllers;

use App\Models\BannerMsg;
use App\Models\bannertype;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class MessageController extends Controller
{
    public function GetLoginBannerMessage()
    {
        $type=bannertype::where('typename','=','LoginBanner')->first();
        $msg=BannerMsg::where('messageTypeID', '=', $type->ID)->latest()->first();
        if ( $msg->Enabled==0) {
            return response( null,200);
        }
        $file=null;
        if ($msg->ImagePath) 
        {
            $file=asset("storage/images/LoginBanner/{$msg->ImagePath}");

        }
        $data = [
            'header'  =>  $msg->Header,
            'file'   => $file,
            'description' => $msg->Description
        ];

        $json= json_encode( $data, JSON_UNESCAPED_SLASHES );
        //error_log(  $json);
        return response( $json,200);
    }

    public function Savemsg(Request $request)
    {
        if (Auth::user()->UserID!=$request->SenderID) {
            return response("Neem szabad felhasználó ID-t módosítani",69);
        }

        $satus=Message::SendMSG($request->message,$request->SenderID,$request->TargetID);
        if ($satus==0) 
        {
            return response()->json(['status'=>0,'message' => 'új üzenet llétrehozva'], 200);
        }elseif ($satus==1) {
            return response()->json(['status'=>1,'message' => 'Cél ID nem található'], 200);
        }else{
            return response()->json(['status'=>2,'message' => 'Sikertelen mentés'], 200);
        }

    }

    
}
