<?php

namespace App\Models;

use App\CustomClasses\Downloader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;

class HomeWorkStudent extends Model
{
    use HasFactory;
    protected $fillable = [
        'StudentID',
        'HomeWorkID',
        'Done',
        'FileName',
        'SubmitDateTime',
        'Answer'
      ];
      protected $primaryKey = ['StudentID', 'HomeWorkID'];
      public $incrementing = false;
    public function GetStudent()
    {
        return $this->belongsTo(Student::class,'StudentID');
    }
    public function GetHomework()
    {
        return $this->belongsTo(HomeWork::class,'HomeWorkID');
    }

    static function AddNewHomework($homeworkID,$studentID,$Done,$FileName,$SubmitDateTime,$Answer)
    {
      $c=null;
      try {
        $c=new self;
        $c->StudentID=$studentID;
        $c->HomeWorkID=$homeworkID;
        $c->Done=$Done;
        $c->FileName=$FileName;
        $c->SubmitDateTime=$SubmitDateTime;
        $c->Answer=$Answer;
        $c->save();
      } catch (\Throwable $th) {
       
        return false;
      }
      
      return true;
    }

    static function RemoveStudentHomework($homeworkID,$studentID) 
    {
      $c=self::GetHomeworkIfExist($homeworkID,$studentID);
      if (!$c) {
        return false;
      }
     
      if (isset($c->FileName)) {
        $folderPath = '\public\homeworks\id_'.$homeworkID;
        $folderStructurePath = storage_path().'\app'. $folderPath;

        $file= $folderStructurePath."\\".$c->FileName;
        if (File::exists( $file)) 
        {
          if (!File::delete( $file)) 
          {
            return false;
          }else
          {

            $FileSystem = new Filesystem();
            if ($FileSystem->exists($folderStructurePath)) 
            {

              $files = $FileSystem->files($folderStructurePath);
              if (empty($files)) 
              {
                $FileSystem->deleteDirectory($folderStructurePath);
              }

            }

          }
        }
       
      }
    


      try {
        if ( DB::delete('DELETE FROM home_work_students WHERE HomeWorkID = ? AND StudentID = ? ', [ $homeworkID,$studentID])) {
          return true;
      }else {
          return false;
        }
      } catch (\Throwable $th) {
        return false;
      }
      return true;
      
    }
    static function GetHomeworkIfExist($homeworkID,$studentID) 
    {
        $c=self::where([
          'HomeWorkID' => $homeworkID,
          'StudentID'=>$studentID
        ])->first();
        if ($c) {
          return $c;
        }else {
          return null;
        }
    }
    
    static function EditAnswer($homeworkID,$studentID,$Answer) 
    {
      try {
        DB::table('home_work_students')
            ->where('HomeWorkID', $homeworkID)
            ->where('StudentID', $studentID)
            ->update(['Answer' => $Answer]);
        
        return true;
      } catch (\Exception $e) {
        error_log($e);
        return false;
      }
  } 
    
}
