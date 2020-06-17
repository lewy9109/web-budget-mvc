<?php


$user_id = $_SESSION['user_id'];
		
$sql = 'SELECT * FROM incomes_category_assigned_to_users WHERE user_id = :id';

$db = static::getDB();
$stmt = $db->prepare($sql);
$stmt->bindValue(':id', $user_id, PDO::PARAM_INT);

$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

$stmt->execute();
while($row =  $stmt->fetch())
{
    echo "<div>";
    echo $row->name;
    echo "</div>";
    echo "</br>";
}
