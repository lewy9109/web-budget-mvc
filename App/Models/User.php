<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{
    /**
     * Error messages
     * 
     * @var arraay
     */
    public $errors = [];

  /**
   * Class constructor
   *
   * @param array $data  Initial property values
   *
   * @return void
   */
  public function __construct($data = [])
  {
      foreach ($data as $key => $value) {
          $this->$key = $value;
      };
  }

  /**
   * Save the user model with the current property values
   *
   * @return void
   */
  public function save()
  {
    $this->validate();

    if(empty($this->errors))
    {
    $password_hash = password_hash($this->password1, PASSWORD_DEFAULT);

    $sql = 'INSERT INTO users (username, email, pass)
            VALUES (:login, :email, :password_hash)';

    $db = static::getDB();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':login', $this->login, PDO::PARAM_STR);
    $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
    $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

      return $stmt->execute();
    }
    return false;
   
  }
  /**
   * 
   * 
   * @return void
   */
  public function validate()
  {
    //Login
    if($this->login == ''){
        $this->errors[] = "Podaj login";
    }

    //email address
    if(filter_var($this->email, FILTER_VALIDATE_EMAIL) == false){
        $this->errors[] = "Niepoprawny email";
    }

    if(static::emailExists($this->email)){
      $this->errors[] = "email jest zajęty";
    }

    //password
    if($this->password1 != $this->password2){
        $this->errors[] = "Hasła nie zgadzją się";
    }

    if(strlen($this->password1) < 6){
        $this->errors[] = "Hasło musi posiadać co najmniej 6 znaków";
    }
  }

  public static function emailExists($email)
  {
    return static::findByEmail($email) != false;
  }

  public static function findByEmail($email)
  {
      $sql = 'SELECT * FROM users WHERE email = :email';

      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);

      $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

      $stmt->execute();

      return $stmt->fetch();
  }

  /**
   * Authenticate a user by email and password.
   *
   * @param string $email email address
   * @param string $password password
   *
   * @return mixed  The user object or false if authentication fails
   */
  public static function  authenticate($email, $password)
  {
      $user = static::findByEmail($email);

      if ($user) {
          if (password_verify($password, $user->pass)) {
              return $user;
          }
      }

      return false;
  }
  /*
  public static function loginExists($login)
  {
    return static::findByLogin($login) != false;
  }

  public static function findByLogin($login)
  {
      $sql = 'SELECT * FROM users WHERE username = :login';

      $db = static::getDB();
      $stmt = $db->prepare($sql);
      $stmt->bindValue(':login', $login, PDO::PARAM_STR);

      $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

      $stmt->execute();

      return $stmt->fetch();
  }

  public static function checkLogin($login, $password)
  {
    $user = static::findByLogin($login);
    if ($user) {
      if (password_verify($password, $user->pass)) {
          return $user;
      }
  }

  return false;

  }
  */
}
