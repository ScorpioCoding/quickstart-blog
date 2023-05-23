<?php

namespace App\Core;

use PDO;
use PDOException;


class Database extends PDO
{

  protected static $db = null;

  /** The database Connection
   * 
   * 
   */
  public function __construct()
  {

    try {
      parent::__construct(

        DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
        DB_USER,
        DB_PASS,
        [
          PDO::ATTR_PERSISTENT            => true,
          PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
          PDO::MYSQL_ATTR_INIT_COMMAND    => 'SET NAMES ' . DB_CHARSET . ' COLLATE ' . DB_COLLATE

        ]


      );
    } catch (PDOException $e) {
      echo 'ERROR!';
      print_r($e);
    }

    //END-Func
  }


  /** Establish Self test
   * 
   */

  public static function getdB()
  {

    if (self::$db === null) {
      self::$db = new Database();
    }
    return self::$db;
  }

  //END-Class
}