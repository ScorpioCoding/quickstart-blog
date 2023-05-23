<?php


namespace Modules\Accounts\Models;

use PDO;
use PDOException;

use App\Core\Database;

use App\Core\NewException;
use RuntimeException;



class mAccounts extends Database
{

  public function __construct()
  {
    parent::__construct();
  }

  public static function setTable()
  {
    try {
      $query = "CREATE TABLE IF NOT EXISTS `accounts` ( 
        id SERIAL PRIMARY KEY,  
        name VARCHAR(255) UNIQUE, 
        email VARCHAR(255) UNIQUE,
        email_validated BOOLEAN DEFAULT FALSE,
        permission VARCHAR(50) NOT NULL,
        psw_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT NOW()
      )";

      $dB = static::getDb();


      return $dB->exec($query);
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }


  public static function create($args = array())
  {
    $password = password_hash($args['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO `accounts` (
      `id`, 
      `name`,
      `email`, 
      `email_validated`, 
      `permission`, 
      `psw_hash`
      )
    VALUES (
      :id, 
      :name,
      :email, 
      :email_validated, 
      :permission, 
      :psw_hash
      )";

    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':id', null, PDO::PARAM_NULL);
    $stmt->bindValue(':name', $args['name'], PDO::PARAM_STR);
    $stmt->bindValue(':email', $args['email'], PDO::PARAM_STR);
    $stmt->bindValue(':email_validated', $args['email_validated'], PDO::PARAM_BOOL);
    $stmt->bindValue(':permission', $args['permission'], PDO::PARAM_STR);
    $stmt->bindValue(':psw_hash', $password, PDO::PARAM_STR);
    try {
      $stmt->execute();
      return $dB->lastInsertId();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }


  public static function readByEmail($email)
  {
    try {
      $query = "SELECT * FROM `accounts` WHERE `email` = :email LIMIT 1";
      $dB = static::getdb();
      $stmt = $dB->prepare($query);
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }


  public static function readByPermission(string $permission)
  {
    try {
      $query = "SELECT * FROM `accounts` WHERE `permission` = :permission LIMIT 1";
      $dB = static::getdb();
      $stmt = $dB->prepare($query);
      $stmt->bindValue(':permission', $permission, PDO::PARAM_STR);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }


  public static function update($args = array())
  {
    try {
      $password = password_hash($args['password'], PASSWORD_DEFAULT);

      $query = "UPDATE `accounts` SET 
        `name`=:name,
        `email`=:email, 
        `email_validated`=:email_validated, 
        `permission`=:permission,
        `psw_hash`=:psw_hash
      WHERE `id` = :id";

      $dB = static::getdb();
      $stmt = $dB->prepare($query);

      $stmt->bindValue(':id', $args['id'], PDO::PARAM_INT);
      $stmt->bindValue(':name', $args['name'], PDO::PARAM_STR);
      $stmt->bindValue(':email', $args['email'], PDO::PARAM_STR);
      $stmt->bindValue(':email_validated', $args['email_validated'], PDO::PARAM_STR);
      $stmt->bindValue(':permission', $args['permission'], PDO::PARAM_STR);
      $stmt->bindValue(':psw_hash', $password, PDO::PARAM_STR);


      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }


  public static function validate($args = array())
  {
    $errorList = array();

    if ($args['name'] == "")
      $errorList[] = 'Username required !';

    if (strlen($args['name']) < 4)
      $errorList[] = 'Username must be more than 4 characters!';

    if (self::userNameExists($args['name']) > 0)
      $errorList[] = 'Username Invalid (duplicate) !';

    if (filter_var($args['email'], FILTER_VALIDATE_EMAIL) === false)
      $errorList[] = 'Administrative Email Invalid!';

    if ($args['password'] == "")
      $errorList[] = 'Administrative Password required !';

    if ($args['psw_confirm'] == "")
      $errorList[] = 'Administrative Confirmation Password required !';

    if ($args['password'] !== $args['psw_confirm'])
      $errorList[] = 'Administrative Confirmation Password must be the same as Password !';

    if (strlen($args['password']) < 6)
      $errorList[] = 'Password must be more than 6 characters!';

    if (preg_match('/.*[a-z]+.*/i', $args['password']) == 0)
      $errorList[] = 'Password needs at least one letter!';

    if (preg_match('/.*\d+.*/i', $args['password']) == 0)
      $errorList[] = 'Password needs at least one number!';

    return $errorList;
  }

  public static function validateLogin($args = array()): array
  {
    $errorList = array();
    //Email address
    if (filter_var($args['email'], FILTER_VALIDATE_EMAIL) === false)
      $errorList[] = 'Invalid Credentials!';

    if (!self::emailExists($args['email']))
      $errorList[] = 'Invalid Credentials!';

    //Password    
    if (strlen($args['password']) < 6)
      $errorList[] = 'Invalid Credentials!';

    if (preg_match('/.*[a-z]+.*/i', $args['password']) == 0)
      $errorList[] = 'Invalid Credentials!';

    if (preg_match('/.*\d+.*/i', $args['password']) == 0)
      $errorList[] = 'Invalid Credentials!';

    return $errorList;
  }

  public static function userNameExists($name)
  {
    try {
      $query = "SELECT * FROM `accounts` WHERE `name`=:name";
      $dB = static::getdb();

      $stmt = $dB->prepare($query);
      $stmt->bindValue(':name', $name, PDO::PARAM_STR);
      return $stmt->rowCount();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public static function emailExists($email)
  {
    return static::getUserByEmail($email) !== false;
  }

  public static function getUserByEmail($email): object
  {
    $query = "SELECT * FROM `accounts` WHERE `email`=:email";

    $dB = static::getdb();

    $stmt = $dB->prepare($query);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
    $stmt->execute();
    return $stmt->fetch();
  }

  public static function authenticate(array $args)
  {
    $user = static::getUserByEmail($args['email']);

    if ($user) {

      try {
        password_verify($args['password'], $user->psw_hash);
        return $user;
      } catch (RuntimeException $e) {
        echo $e->getMessage();
      }
    }
    return false;
  }

  //
  //END CLASS
}
