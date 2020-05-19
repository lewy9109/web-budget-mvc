<?php

namespace App;



class Flash 
{
    public static function addMessage($message)
    {
       
        if(!isset($_SESSION['flash_nottifications']))
        {
            $_SESSION['flash_nottifications'] = [];
        }

        $_SESSION['flash_nottifications'] [] = $message;
    }

    public static function getMessage()
    {
        if(isset($_SESSION['flash_nottifications']))
        {
            $message = $_SESSION['flash_nottifications'];
            unset($_SESSION['flash_nottifications']);
            return $message;
        }
    }
}

