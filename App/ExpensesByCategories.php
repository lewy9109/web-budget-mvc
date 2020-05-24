<?php

namespace App;

use App\Models\BilansManager;

/**
 * Get incomes of logged-in user
 *
 * PHP version 7.0
 */
class ExpensesByCategories 
{
	public static function getExpensesByCategories()
    {
        if(isset($_SESSION['user_id']))
        {
            return BilansManager::getExpensesGroupedByCategories();
        }
    }

}