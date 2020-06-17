<?php

namespace App\Controllers;

use \Core\View;
use App\Models\BudgetManager;



class Profile extends Authenticated
{

    public function showAction()
    {
        View::renderTemplate('Settings/index.html'/*, ['user'=>Auth::getUser()]*/);
    }

    public function editAction()
    {

        BudgetManager::getIncomesCategory();
        
    }

}