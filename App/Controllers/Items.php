<?php

namespace App\Controllers;

use App\Auth;
use App\Models\BilansManager;
use \Core\View;


class Items extends Authenticated
{
    

    public function indexAction()
    {
        View::renderTemplate('Items/index.html',
        ['bilanceE'=>BilansManager::showExpense(), 'bilanceIncome'=>BilansManager::showIncome()] 
        );
        //['bilanceIncome'=>BilansManager::showIncome()]
 
    }

    
    

}
