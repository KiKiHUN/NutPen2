<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannedIP extends Model
{
    use HasFactory;
    protected $fillable = ['ID','clientID','UUIDBanned','clientIP','IPBanned'];
    protected $primaryKey = 'ID';
    public $incrementing = true;

    static function  EditFullBannIfExist($ID,$UUIDbanned,$IPbanned) 
    {   
        $b=self::where([
            'ID' => $ID
        ])->first();
        error_log($b);
        if ($b) {
           $b->UUIDBanned=$UUIDbanned;
           $b->IPBanned=$IPbanned;
           $b->save();
        }else {
            return false;
        }
        return true;
    }
    static function  EditUUIDBannIfExist($ID,$UUIDbanned) 
    {   
        $b=self::where([
            'ID' => $ID
        ])->first();
        error_log($b);
        if ($b) {
           $b->UUIDBanned=$UUIDbanned;
           $b->save();
        }else {
            return false;
        }
        return true;
    }
    static function AddNewBann($UUID,$IP,$UUIDbanned,$IPbanned) 
    {   
        $banned = new BannedIP();
        $banned->clientID = $UUID;
        $banned->UUIDBanned = $UUIDbanned;
        $banned->clientIP=$IP;
        $banned->IPBanned=$IPbanned;
        if (  $banned->save()) {
            return true;
        }else
        {
            return false;
        }
      
    }
}
