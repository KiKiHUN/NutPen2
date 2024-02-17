<?php
namespace App\CustomClasses;

use App\Models\Admin;
use App\Models\HeadUser;
use App\Models\Student;
use App\Models\StudParent;
use App\Models\Teacher;

class UserIDFunctions {
    public static function UserIDLookup($UserID)
    {
        switch ($UserID[0]) {
            case 'a':
                return new Admin;
                break;
            
            case 's':
               return new Student();
                break;
            case 'h':
                return new HeadUser();
                break;
            case 'p':
                return new StudParent();
                break;
            case 't':
                return new Teacher();
                break;
        }
    }
}

?>