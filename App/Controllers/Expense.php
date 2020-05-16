<?php

namespace App\Controllers;

use App\Models\BudgetManager;
use App\Models\User;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Expense extends \Core\Controller
{

    /**
     * Show the income page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Expense/index.html');
    }

    public function createAction()
    {
        $expense = new BudgetManager($_POST);
        if($expense->saveExpense())
        {
            echo "Dodano";
            exit;
        }else{
           echo "Nie udalo sie";
        }
  
        
    }
}