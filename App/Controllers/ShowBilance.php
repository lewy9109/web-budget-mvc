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
        if (isset($_SESSION['custom_start']) && isset($_SESSION['custom_end']))
        {
            unset($_SESSION['custom_start']);
            unset($_SESSION['custom_end']);
        }
		$_SESSION['period'] = $bilance->periodsOptions;

        View::renderTemplate('ShowBilance/index.html',
        ['bilanceE'=>BilansManager::getExpenseIncludeDate(),
        'bilanceIncome'=>BilansManager::getIncomeIncludeDate(),
        ]); 
    }   

    
    public function showAction()
    {
        $bilance = new BilansManager($_POST);

        if(isset($bilance->periodsOptions))
        {
            $_SESSION['period'] = $bilance->periodsOptions;
        }

        if(isset($bilance->current_month))
        {
             $_SESSION['period'] = $bilance->current_month;
        }

        if(isset($bilance->previous_month))
        {
             $_SESSION['period'] = $bilance->previous_month;
        }
        if(isset($bilance->current_year))
        {
            $_SESSION['period'] = $bilance->current_year;
        }

        if(isset($bilance->custom_start) && isset($bilance->custom_end))
        {
            $_SESSION['custom_start'] = $bilance->custom_start;
            $_SESSION['custom_end'] = $bilance->custom_end;
            if (isset($_SESSION['period']))
			{
				unset($_SESSION['period']);
			}
        }
 

        View::renderTemplate('ShowBilance/index.html',
        ['bilanceE'=>BilansManager::getExpenseIncludeDate(),
        'bilanceIncome'=>BilansManager::getIncomeIncludeDate(),
        ]); 
  
    }
    
}
