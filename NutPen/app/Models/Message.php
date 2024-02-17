<?php

namespace App\Models;

use App\CustomClasses\UserIDFunctions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'ID',
        'SenderID',
        'TargetID',
        'Message',
        'SentDateTime',
        'Flagged'
      ];
      protected $primaryKey = 'ID';
      public $incrementing = true;

    

    public static function getTopXMessagesByID($UserID,$count)
    {
        $messageChats = [];

        // $UserID az a küldő vagy a fogadó
        $messages = self::where('SenderID', $UserID)
                        ->orWhere('TargetID', $UserID)
                        ->orderBy('SentDateTime', 'ASC')
                        ->get();
       
        // $UserID párkapcsolat alapján csoportosítani
        $groupedMessages = $messages->groupBy(function ($message) use ($UserID) {
            return $message->SenderID === $UserID ? $message->TargetID : $message->SenderID;
        });
        
        $messageChatID = 1;
        // kiválogatni melyik a base és melyik a válasz
        foreach ($groupedMessages as $key => $conversation) {
            $messageChat = new MessageChat();

            $messageChat->ID = $messageChatID++;
            // base üzenet
            $messageChat->basemsg = $conversation->first();
    
            // válasz, ha létezik
            $replyExists = $conversation->where('ID', '!=', $messageChat->basemsg->ID)->first();

            $messageChat->reply = $replyExists ? $replyExists : null;
            
            $messageChats[] = $messageChat;
        }
        //dd($messageChats);
        return array_slice($messageChats, 0, $count);
    }
    

    public static function SendMSG($message,$senserid,$targetid)
    {
        $azonositoValaszto = mb_substr($targetid, 0, 1);
        $user=null;
        switch ($azonositoValaszto) {
            case 'a':
                $user = Admin::where('UserID', $targetid )->exists();
                break;
            case 's':
                $user = Student::where('UserID', $targetid )->exists();
                break;
            case 't':
                $user = Teacher::where('UserID', $targetid )->exists();
                break;
            case 'p':
                $user = StudParent::where('UserID', $targetid )->exists();
                break;
            case 'h':
                $user = HeadUser::where('UserID', $targetid )->exists();
                break;
        }
       if ($user==null) {
        return 1;
       }
        $existingMessage = self::where('SenderID', $senserid)
        ->where('TargetID', $targetid)
        ->first();
        try 
        {
            if ($existingMessage) 
            {
                $existingMessage->delete();
            } 
                $newMessage = new Message();
                $newMessage->SenderID = $senserid;
                $newMessage->TargetID = $targetid;
                $newMessage->Message = $message;
                $newMessage->SentDateTime = now(); 
                $newMessage->save();
                return 0;
            
        } catch (\Throwable $th) {
            return -1;
        }
    }

    

   
}

class MessageChat {
    public $ID=0;
    public $basemsg;
    public $reply;
}

