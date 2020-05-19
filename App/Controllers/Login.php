<?php

namespace App\Controllers;

use App\Auth;
use Core\View;
use App\Models\User;
use APP\Flash;

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
        $user = User::authenticate($_POST['login'], $_POST['password']);
        
        if($user){

            Auth::login($user);

            //Flash::addMessage('Zalogowano !');
            $this->redirect(Auth::getReturnToPage());

            
        }else{
            Flash::addMessage('Nieudane logowanie, spróbuj jeszcze raz');
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
