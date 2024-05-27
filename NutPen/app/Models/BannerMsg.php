<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BannerMsg extends Model
{
    use HasFactory;
    protected $fillable = [
        'messageTypeID',
        'Header',
        'Description',
        'ImagePath',
        'Enabled'
      ];
      protected $primaryKey = 'ID';
      public $incrementing = true;
      protected $keyType="integer";
    public function GetType()
    {
        return $this->belongsTo(bannertype::class,'messageTypeID');
    }

    static function AddNewMSG($name,$desc,$image,$enabled)
    {
      $type=bannertype::where('typename','=','LoginBanner')->first();
      try {
        $c=new self;
        $c->Header=$name;
        $c->Description=$desc;
        $c->ImagePath=$image;
        $c->Enabled=$enabled;
        $c->messageTypeID=$type->ID;
      
        $c->save();
      } catch (\Throwable $th) {
        //dd($th);
        return false;
      }
      return true;
    }

    static function EditMSG($msgID,$name,$desc,$image) 
    {
      $c=self::GetMSGIfExist($msgID);
      if (!$c) {
       return false;
      }
      
      try {
        $c->Header=$name;
        $c->Description=$desc;
        if ($image!=null) {
          $c->ImagePath=$image;
        }
        $c->save();
      } catch (\Throwable $th) {
       return false;
      }
      return true;
      
    }
    static function ChangeMSG($msgID) 
    {
        if ($msgID!=-1) {
            $c=self::GetMSGIfExist($msgID);
            if (!$c) {
             return false;
            }
            $c->Enabled=1;
            $c->save();
        }
        DB::beginTransaction();
        try {
            foreach (self::all() as $msg) {
                if ($msg->ID!=$msgID) {
                        $msg->Enabled=0;
                        $msg->save();
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
        DB::commit();
      return true;
      
    }
    
    static function RemoveMSG($msgID) 
    {
      $c=self::GetMSGIfExist($msgID);
      if (!$c) {
        return false;
      }
      
      try {
        if ( DB::delete('DELETE FROM banner_msgs WHERE ID = ? ', [ $msgID])) {
          return true;
      }else {
          return false;
        }
      } catch (\Throwable $th) {
        return false;
      }
      return true;
      
    }


    static function GetMSGIfExist($msgID) 
    {
        $c=self::where([
          'ID' => $msgID
        ])->first();
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
    
}
