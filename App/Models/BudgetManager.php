<?php

namespace App\Models;

use PDO;

class BudgetManager extends \Core\Model
{

        /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

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

        /**
     * Save the income with the current property values
     *
     * @return boolean  True if the operation was saved, false otherwise
     */
	public function saveIncome()
	{
        $this->validate();
        
		$income_category_id = $this->getIncomeId();
		
		if (empty($this->errors)) 
		{
			$sql = 'INSERT INTO incomes (user_id, income_category_assigned_to_user_id, amount, date_of_income, income_comment) 
					VALUES (:user_id, :income_category_assigned_to_user_id, :amount, :date_of_income, :income_comment)';

			$db = static::getDB();
			$stmt = $db->prepare($sql);

			$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':income_category_assigned_to_user_id', $income_category_id, PDO::PARAM_INT);
			$stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
			$stmt->bindValue(':date_of_income', $this->date, PDO::PARAM_STR);
			$stmt->bindValue(':income_comment', $this->comment, PDO::PARAM_STR);

			return $stmt->execute();
		}
		
		return false;
		
    }
            /**
     * Save the expense with the current property values
     *
     * @return boolean  True if the operation was saved, false otherwise
     */
	public function saveExpense()
	{
        $this->validate();
        
        $expense_category_id = $this->getExpenseId();
        $payment_id = $this->getIdPayment();
		
		if (empty($this->errors)) 
		{
			$sql = 'INSERT INTO expenses VALUES (NULL, :user_id, :expense_category_assigned_to_user_id, :payment_method_assigned_to_user_id, :amount, :date_of_expense, :expense_comment)';

			$db = static::getDB();
			$stmt = $db->prepare($sql);

			$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':expense_category_assigned_to_user_id', $expense_category_id, PDO::PARAM_INT);
            $stmt->bindValue(':payment_method_assigned_to_user_id', $payment_id, PDO::PARAM_INT);
			$stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
			$stmt->bindValue(':date_of_expense', $this->date, PDO::PARAM_STR);
			$stmt->bindValue(':expense_comment', $this->comment, PDO::PARAM_STR);

			return $stmt->execute();
		}
		
		return false;
		
    }

    /**
     * Get the income category id from database
     *
     * @return integer with id of income category
     */
	public function getIncomeId()
	{
		$user_id = $_SESSION['user_id'];
		$income_category = $this->category;
		
		$sql = 'SELECT id FROM incomes_category_assigned_to_users WHERE user_id = :id AND name = :name';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $income_category, PDO::PARAM_STR);
		
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		$row = $stmt->fetch();
		
		return $row->id;
    }
    
        /**
     * Get the income category id from database
     *
     * @return integer with id of income category
     */
	public function getExpenseId()
	{
		$user_id = $_SESSION['user_id'];
		$expense_category = $this->category;
		
		$sql = 'SELECT id FROM expenses_category_assigned_to_users WHERE user_id = :id AND name = :name';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $expense_category, PDO::PARAM_STR);
		
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		$row = $stmt->fetch();
		
		return $row->id;
    }
    
    public function getIdPayment()
    {
        $user_id = $_SESSION['user_id'];
		$namePayment = $this->categoryPayment;
		
		$sql = 'SELECT id FROM payment_methods_assigned_to_users WHERE user_id = :id AND name = :name';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $namePayment, PDO::PARAM_STR);
		
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		$row = $stmt->fetch();
		
		return $row->id;
    }

    /**
     * Validate 
     * 
     * 
     */
    
    public function validate()
    {
        //Check amount
        if (strpos($this->amount, ",") == true)
		{
		   $this->amount = str_replace(",",".",$this->amount);
		}
       
        
        if($this->amount == ''){
            $this->errors[] = "Podaj kwote";
        }
        
        if(!is_numeric($this->amount)|| $this->amount < 0)
        {
            $this->errors[] = "Podaj poprawna wartość";
        }

        //Check data

        
        if(strlen($this->date) < 10 && strlen($this->date) > 0 )
        {
            $this->errors[] ="Nie prawidłowy format daty: yyyy-mm-dd";
        }
        
        if(!empty($this->date))
        {
            $year = substr($this->date, 0, 4);
            $month = substr($this->date, 5,2);
            $day = substr($this->date, 8,2);

            if(!checkdate($month, $day, $year))
            {
                $this->errors[] = "Nie prawidłowy format daty: yyyy-mm-dd";
            }
        }else{
            $data = new \DateTime();
            $this->date = $data->format('Y-m-d');
        }
        
        $this->date = static::getDateForDatabase($this->date);
        //Check comment
        if ((strlen($this->comment) > 100)) 
		{
			$this->errors[] = "Komentarz może miec maksymalnie 100 znaków !";
        }

    }       
       
    public static function getDateForDatabase(string $date): string 
    {
        $timestamp = strtotime($date);
        $date_formated = date('Y-m-d H:i:s', $timestamp);
        return $date_formated;
    }

    public static function getIncomesCategory()
    {
        
        $user_id = $_SESSION['user_id'];
		
		$sql = "SELECT name FROM incomes_category_assigned_to_users WHERE user_id = '$user_id'";

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        //$stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
		
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
		while($row =  $stmt->fetch())
        {
            
            echo "<div class = 'incomeCat'>";

                echo "<div class='categoryName' id='$row->name'>";
                   // echo "<input type='checkbox' id='$row->name' name='$row->name' value='$row->name'>";
                   // echo "<label for='$row->name' style='margin-left: 10px; letter-spacing: 3px;'>$row->name</label>";
                    echo $row->name;
                echo "</div>";

                echo "<div>";
                    echo "<button type='button' class='btn btn-primary edit' data-toggle='modal' data-target='#exampleModal' id='$row->name' value='$row->name'>
                    <div class ='icon-pencil'>Edytuj</div>
                    </button>";

                    echo "<button type='button' class='btn btn-primary delete' style='background-color: rgb(233, 76, 76); ' data-toggle='modal' data-target='#exampleModal2'>
                    <div class ='icon-minus-1'>Usuń</div>
                </button>";
                echo "</div>";

            echo "</div>";
        }
        /*
        echo "<div class = 'incomeCatedit'>";
            echo "<button type='button' class='btn btn-primary edit' data-toggle='modal' data-target='#exampleModal' style='width: 50%'>
            <div class ='icon-pencil'>Edytuj</div>
            </button>";

            echo "<button type='button' class='btn btn-primary delete' style='background-color: rgb(233, 76, 76); width: 50%;' data-toggle='modal' data-target='#exampleModal2'>
            <div class ='icon-minus-1'>Usuń</div>
            </button>";
        echo "</div>";
       */
    }


}