<?php

namespace App\Controllers;

use App\Auth;
use App\Models\BilansManager;
use \Core\View;


class ShowBilance extends Authenticated
{
    
    public function indexAction()
    {   
        $age = array("periodsOptions"=>"current_month");

        $bilance = new BilansManager($age);
        
        $_SESSION['period'] = $bilance->periodsOptions;

        View::renderTemplate('ShowBilance/index.html',
        ['bilanceE'=>BilansManager::getExpenseIncludeDate(),
        'bilanceIncome'=>BilansManager::getIncomeIncludeDate(),
        ]); 
}

    
    public function showAction()
    {
        $balance = new BilansManager($_POST);
        
		if(isset($balance->periodsOptions))
		{
            $_SESSION['period'] = $balance->periodsOptions;
            View::renderTemplate('ShowBilance/index.html',
            ['bilanceE'=>BilansManager::getExpenseIncludeDate(),
            'bilanceIncome'=>BilansManager::getIncomeIncludeDate(),
            ]); 
			

        }
    }
    
}