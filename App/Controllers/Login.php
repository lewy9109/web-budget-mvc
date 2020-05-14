<?php

namespace App\Controllers;

use App\Auth;
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
        //checklogin() - logowanie przez login; autoritathe() - logowanie przez email;
        $user = User::checkLogin($_POST['login'], $_POST['password']);
        
        if($user){

            Auth::login($user);

            //przekierowanie na strone po udanym logowaniu
                //header('Location: http://'.$_SERVER['HTTP_HOST'].'/', true, 303);
            //przekierowanie przez funkcje 
            //$this->redirect('/');
            $this->redirect(Auth::getReturnToPage());

            exit;
        }else{
            
            View::renderTemplate('Login/new.html', ['login' => $_POST['login']]);
        }
        
    }

    public function destroyAction()
    {
        // Unset all of the session variables.
        Auth::logout();

        $this->redirect('/');
    }
}
