<?php

namespace App;

use App\Models\BilansManager;


/**
 * Get incomes of logged-in user
 *
 * PHP version 7.0
 */
class IncomesByCategories 
{
	public static function getIncomesByCategories()
  {
      if(isset($_SESSION['user_id']))
      {
        return BilansManager::getIncomesGroupedByCategories();
      }
		 
  }
}
