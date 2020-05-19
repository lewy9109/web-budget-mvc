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
        WHERE i.user_id = $userid AND i.income_category_assigned_to_user_id = ia.id";
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
        WHERE i.user_id = $userid AND i.expense_category_assigned_to_user_id = ia.id";
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $userid, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
        return  $stmt->fetchAll();
        
    }
    public static function showAll()
    {
        $userid = $_SESSION['user_id'];

        $sql = "SELECT e.amount, e.date_of_expense, ea.name, i.amount, i.date_of_income, ia.name
        FROM expenses AS e, expenses_category_assigned_to_users AS ea, incomes AS i, incomes_category_assigned_to_users AS ia
        WHERE e.user_id = :id AND e.expense_category_assigned_to_user_id = ea.id AND i.user_id = :id AND i.income_category_assigned_to_user_id = ia.id ";
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $userid, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
        return  $stmt->fetchAll();
    }

}