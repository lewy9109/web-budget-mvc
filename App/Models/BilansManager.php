<?php

namespace App\Models;

use PDO;

class BilansManager extends \Core\Model
{

        /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];
    public $income = [];

        /**
     * Class constructor
     *
     * @param array $operation  Initial property values
     *
     * @return void
     */
    public function __construct($operation = [])
    {
        foreach ($operation as $key => $value) 
		{
            $this->$key = $value;
        };
    }

    public static function showIncome()
    {
        $userid = $_SESSION['user_id'];
        $sql = "SELECT i.amount, i.date_of_income, ia.name
        FROM incomes AS i, incomes_category_assigned_to_users AS ia
        WHERE i.user_id = :id AND i.income_category_assigned_to_user_id = ia.id";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $userid, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
        return  $stmt->fetchAll();
        
    }

    public static function showExpense()
    {
        $userid = $_SESSION['user_id'];
        $sql = "SELECT i.amount, i.date_of_expense, ia.name
        FROM expenses AS i, expenses_category_assigned_to_users AS ia
        WHERE i.user_id = :id AND i.expense_category_assigned_to_user_id = ia.id";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $userid, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
        return  $stmt->fetchAll();
    }

    public static function getExpenseIncludeDate()
    {
        $date = new \DateTime();
        
        $userid = $_SESSION['user_id'];
        
        $period = $_SESSION['period'];
        
        if($period == "current_month")
        {
            $endDate =  $date->format('Y-m-d') . "\n";
            $date->modify('first day of this month');
            $startData = $date->format('Y-m-d') . "\n";
        }

        if($period == "previous_month")
        {
            $date->modify('last day of -1 month');
            $endDate =  $date->format('Y-m-d') . "\n";
            $date->modify('first day of this month');
            $startData = $date->format('Y-m-d') . "\n";
        }

        if($period == "current_year")
        {
            $endDate =  $date->format('Y-m-d') . "\n";
            $month = substr($date->format('Y-m-d'), 5,2);

            if(substr($month, 0,1) == '0')
            {
                $month = substr($month, 1,1); 
                $month -= 1;
            }else{
                $month -= 1;
            }
            
            $date->modify("first day of - $month month");
            $startData = $date->format('Y-m-d') . "\n";
        }
        
        $sql = "SELECT i.amount, i.date_of_expense, ia.name
        FROM expenses AS i, expenses_category_assigned_to_users AS ia
        WHERE i.user_id = :id AND i.expense_category_assigned_to_user_id = ia.id 
        AND i.date_of_expense BETWEEN :FirstTime AND :LastTime ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $userid, PDO::PARAM_INT);
        $stmt->bindValue(':FirstTime', $startData, PDO::PARAM_STR);
        $stmt->bindValue(':LastTime', $endDate, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
       
        return  $stmt->fetchAll();
    }

    public static function getIncomeIncludeDate()
    {
        $date = new \DateTime();
        
        $userid = $_SESSION['user_id'];
        
        $period = $_SESSION['period'];
        
        if($period == "current_month")
        {
            $endDate =  $date->format('Y-m-d') . "\n";
            $date->modify('first day of this month');
            $startData = $date->format('Y-m-d') . "\n";
        }

        if($period == "previous_month")
        {
            $date->modify('last day of -1 month');
            $endDate =  $date->format('Y-m-d') . "\n";
            $date->modify('first day of this month');
            $startData = $date->format('Y-m-d') . "\n";
        }

        if($period == "current_year")
        {
            $endDate =  $date->format('Y-m-d') . "\n";
            $month = substr($date->format('Y-m-d'), 5,2);

            if(substr($month, 0,1) == '0')
            {
                $month = substr($month, 1,1); 
                $month -= 1;
            }else{
                $month -= 1;
            }
            
            $date->modify("first day of - $month month");
            $startData = $date->format('Y-m-d') . "\n";
        }
        
        $sql = "SELECT i.amount, i.date_of_income, ia.name
        FROM incomes AS i, incomes_category_assigned_to_users AS ia
        WHERE i.user_id = :id AND i.income_category_assigned_to_user_id = ia.id 
        AND i.date_of_income BETWEEN :FirstTime AND :LastTime ";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $userid, PDO::PARAM_INT);
        $stmt->bindValue(':FirstTime', $startData, PDO::PARAM_STR);
        $stmt->bindValue(':LastTime', $endDate, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
       
        return  $stmt->fetchAll();
    }

    public static function getIncomeTotalAmount()
    {

        $date = new \DateTime();
        
        $userid = $_SESSION['user_id'];
        
        $period = $_SESSION['period'];
        
        if($period == "current_month")
        {
            $endDate =  $date->format('Y-m-d') . "\n";
            $date->modify('first day of this month');
            $startData = $date->format('Y-m-d') . "\n";
        }

        if($period == "previous_month")
        {
            $date->modify('last day of -1 month');
            $endDate =  $date->format('Y-m-d') . "\n";
            $date->modify('first day of this month');
            $startData = $date->format('Y-m-d') . "\n";
        }

        if($period == "current_year")
        {
            $endDate =  $date->format('Y-m-d') . "\n";
            $month = substr($date->format('Y-m-d'), 5,2);

            if(substr($month, 0,1) == '0')
            {
                $month = substr($month, 1,1); 
                $month -= 1;
            }else{
                $month -= 1;
            }
            
            $date->modify("first day of - $month month");
            $startData = $date->format('Y-m-d') . "\n";
        }

        $sql = "SELECT SUM(amount) AS sum FROM incomes 
        WHERE user_id = :id AND date_of_income BETWEEN :FirstTime AND :LastTime ";
 
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $userid, PDO::PARAM_INT);
        $stmt->bindValue(':FirstTime', $startData, PDO::PARAM_STR);
        $stmt->bindValue(':LastTime', $endDate, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

       return $stmt->fetch();

    }

    public static function getExpenseTotalAmount()
    {

        $date = new \DateTime();
        
        $userid = $_SESSION['user_id'];
        
        $period = $_SESSION['period'];
        
        if($period == "current_month")
        {
            $endDate =  $date->format('Y-m-d') . "\n";
            $date->modify('first day of this month');
            $startData = $date->format('Y-m-d') . "\n";
        }

        if($period == "previous_month")
        {
            $date->modify('last day of -1 month');
            $endDate =  $date->format('Y-m-d') . "\n";
            $date->modify('first day of this month');
            $startData = $date->format('Y-m-d') . "\n";
        }

        if($period == "current_year")
        {
            $endDate =  $date->format('Y-m-d') . "\n";
            $month = substr($date->format('Y-m-d'), 5,2);

            if(substr($month, 0,1) == '0')
            {
                $month = substr($month, 1,1); 
                $month -= 1;
            }else{
                $month -= 1;
            }
            
            $date->modify("first day of - $month month");
            $startData = $date->format('Y-m-d') . "\n";
        }

        $sql = "SELECT SUM(amount) AS sum FROM expenses 
        WHERE user_id = :id AND date_of_expense BETWEEN :FirstTime AND :LastTime ";
 
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $userid, PDO::PARAM_INT);
        $stmt->bindValue(':FirstTime', $startData, PDO::PARAM_STR);
        $stmt->bindValue(':LastTime', $endDate, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

       return $stmt->fetch();

    }


}