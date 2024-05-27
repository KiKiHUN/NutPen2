<?php
namespace App\CustomClasses;
class PwHasher {
    public static function HashPWText($stringpw, $salt = null)
    {
        $prefix = '$2y$';
        $cost = '10';
        if ($salt === null) {
            $salt = self::generateSalt();
        }
       
        $blowfishPrefix = $prefix . $cost . '$' . $salt;
        $hash = crypt($stringpw, $blowfishPrefix);
        return $hash;
    }
    public static function PWCompare($stringpw,$dbpw):bool
    {
        $salt = self::getSaltFromHash($dbpw);
        $hash=self::HashPWText($stringpw,$salt);
        if ($hash!=$dbpw) {
           return false;
        }
       return  true;
    }
    private static function generateSalt()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = "";

        // Generate a 22-character random string
        for ($i = 0; $i < 22; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
    public static function getSaltFromHash($pw)
    {   //pw ex: $2y$10$Ax3jS2duEkywZMLjbGxv5e8oE8gv9iw6DprIs9XxMeglhOuHXOf6K
        return substr($pw, 7, 22);
    }
}

?>