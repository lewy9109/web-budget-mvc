<?php

namespace App;

use App\Models\BilansManager;

/**
 * Get user's total income amount
 *
 * PHP version 7.0
 */
class TotalIncome
{
	public static function getTotalUserIncome()
    {
      if (isset($_SESSION['user_id']))
      {
        return BilansManager::getIncomeTotalAmount();
      }
		
    }
}
