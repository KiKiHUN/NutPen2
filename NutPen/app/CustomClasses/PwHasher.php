<?php
namespace App\CustomClasses;
class PwHasher {
    public static function hasheles($be)
    {
        $prefix = '$2y$';
        $cost = '10';
        $salt = '$GodLuckCrackingThePW69$';
        $blowfishPrefix = $prefix.$cost.$salt;
        $password = $be;
        $hash = crypt($password, $blowfishPrefix);
       return  $hash;
    }
}

?>