<?php

namespace App\Controllers;

Use Core\View;
Use App\Models\User;

/**
 * Login controller
 *
 * PHP version 7.0
 */
class Login extends \Core\Controller
{
    /**
     * show the login page
     * 
     */
    public function newAction()
    {
        View::renderTemplate('Login/new.html');
    }

    public function createAction()
    {
        
       
        $user = User::authenticate($_POST['email'], $_POST['password']);
        
         
        if($user){
            //przekierowanie na strone po udanym logowaniu
            //header('Location: http://'.$_SERVER['HTTP_HOST'].'/', true, 303);
            //przekierowanie przez funkcje 
            $this->redirect('/');

            exit;
        }else{
            View::renderTemplate('Login/new.html', ['email' => $_POST['email']]);
        }
        
    }
}
