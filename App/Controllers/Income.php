<?php

namespace App\Controllers;

use App\Models\BudgetManager;
use \Core\View;


/**
 * Home controller
 *
 * PHP version 7.0
 */
class Income extends Authenticated
{

    /**
     * Show the income page
     *
     * @return void
     */
    public function indexAction()
    {
        
        View::renderTemplate('Income/index.html');
    }

    public function createAction()
    {
        $income = new BudgetManager($_POST);
        if($income->saveIncome())
        {
            $this->redirect('/item');
            exit;
        }else{
            $this->redirect('/income');
        }
  
        
    }
}