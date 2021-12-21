<?php
session_start();
    $db = new SQLite3('mydb.db');

    // FUNCTION
    function Securise($string)
    {
        if(ctype_digit($string))
        {
           $string = intval($string); 
        } else {
            $string = strip_tags($string);
            $string = addcslashes($string,'%_');
        }
        return $string;
    }

    function PasswordHash($string)
    {
        $string = sha1(md5($string));
        return $string;
    }

?>