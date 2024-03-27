<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'Name',
        'Description'
      ];
      protected $primaryKey = 'ID';
      public $incrementing = true;
      protected $keyType="integer";
    public function GetLessons()
    {
        return $this->hasMany(Lesson::class,"SubjectID");
    }
    static function AddNewSubject($name,$desc)
    {
      try {
        $c=new self;
        $c->Name=$name;
        $c->Description=$desc;
        $c->save();
      } catch (\Throwable $th) {
        return false;
      }
      return true;
    }

    static function EditSubject($subjectID,$name,$desc) 
    {
      $c=self::GetSubjectIfExist($subjectID);
      if (!$c) {
       return false;
      }
      
      try {
        $c->Name=$name;
        $c->Description=$desc;
        $c->save();
      } catch (\Throwable $th) {
       return false;
      }
      return true;
      
    }
    static function GetSubjectIfExist($subjectID) 
    {
        $c=self::where([
          'ID' => $subjectID
        ])->first();
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
}
