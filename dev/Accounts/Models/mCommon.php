<?php


namespace Modules\Accounts\Models;

use PDO;
use PDOException;

use App\Core\Database;

use App\Core\NewException;



class mCommon extends Database
{

  public function __construct()
  {
    parent::__construct();
  }

  public static function testForConnection()
  {
    $rtn = false;
    try {
      if ($db = self::getdB()) {
        $rtn = true;
      } else {
        throw new NewException("mCommon::testForConnection:: No dB connection available.");
      }
    } catch (NewException $e) {
      echo $e->getErrorMsg();
    }
    return $rtn;
  }

  public static function testForTable(string $table): bool
  {
    $rtn = false;
    try {
      $query = "SELECT 1 FROM `$table` LIMIT 1";
      $dB = self::getdb();
      $stmt = $dB->prepare($query);
      $stmt->execute();
      $rtn = true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      $rtn = false;
    }
    return $rtn;
  }

  public static function createEmptyRow(string $table)
  {
    try {

      $query = "INSERT INTO `$table` ( `id`)
      VALUES ( :id )";


      $dB = static::getdb();
      $stmt = $dB->prepare($query);

      $stmt->bindValue(':id', NULL, PDO::PARAM_INT);


      $stmt->execute();
      return $dB->lastInsertId();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }



  public static function readTableById(string $table, $id)
  {
    try {
      $query = "SELECT * FROM `$table` WHERE `id`=:id LIMIT 1";
      $dB = static::getdb();
      $stmt = $dB->prepare($query);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }

  public static function readTableByAccountId(string $table, $id)
  {
    try {
      $query = "SELECT * FROM `$table` WHERE `acc_id`=:acc_id LIMIT 1";
      $dB = static::getdb();
      $stmt = $dB->prepare($query);
      $stmt->bindValue(':acc_id', $id, PDO::PARAM_INT);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }

  public static function readTableByType(string $table, $type)
  {
    try {
      $query = "SELECT * FROM `$table` WHERE `comType`=:comType";
      $dB = static::getdb();
      $stmt = $dB->prepare($query);
      $stmt->bindValue(':comType', $type, PDO::PARAM_STR);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }

  public static function searchTableByName(string $table, $name)
  {
    try {
      $query = "SELECT * FROM `$table` WHERE `comName` LIKE CONCAT('%', :comName, '%')";
      $dB = static::getdb();
      $stmt = $dB->prepare($query);
      $stmt->bindValue(':comName', $name, PDO::PARAM_STR);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }

  public static function readTable(string $table)
  {
    try {
      $query = "SELECT * FROM `$table` ";
      $dB = static::getdb();
      $stmt = $dB->prepare($query);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }


  /**
   * @param string table
   * @param string order
   */
  public static function readTableOrderBy(string $table, string $order)
  {
    try {
      $query = "SELECT * FROM `$table` ORDER BY `$order` ";
      $dB = static::getdb();
      $stmt = $dB->prepare($query);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }


  /**
   * @param string table
   * @param string order
   * @param int limit
   * @param int offset
   */
  public static function readTableOrderLimitOffset(string $table, string $order, int $limit, int $offset)
  {
    try {
      $query = "SELECT * FROM `$table` ORDER BY `$order` LIMIT $limit OFFSET $offset";
      $dB = static::getdb();
      $stmt = $dB->prepare($query);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }


  public static function createTables(int $user_id)
  {
    //Here we create tables connected to the user
    //1. test for connection again 
    $con = mCommon::testForConnection();

    //.2 Create the tables
    // mAddress::setTable();
    // mProfile::setTable();
    // mLink::setTable();
    // mCompany::setTable();

    // //3. Profile Chain
    // if (self::testForTable('profile')) {
    //   if (self::testForTable('address')) {
    //     if (self::testForTable('link')) {

    //       $data = array();
    //       $address_id = self::createEmptyRow('address');
    //       $data = mAddress::getFakeData($address_id);
    //       mAddress::update($data);

    //       $data = array();
    //       $profile_id = self::createEmptyRow('profile');
    //       $data = mProfile::getFakeData($user_id, $profile_id, $address_id);
    //       mProfile::update($data);

    //       $data = array();
    //       $data['id'] = self::createEmptyRow('link');
    //       $data['profile_id'] = $profile_id;
    //       mLink::update($data);
    //     }
    //   }
    // }

    // //4. Company Chain
    // if (self::testForTable('profile')) {
    //   if (self::testForTable('address')) {
    //     if (self::testForTable('metadata')) {

    //       $data = array();
    //       $address_id = self::createEmptyRow('address');
    //       $data = mAddress::getFakeData($address_id);
    //       mAddress::update($data);

    //       $data = array();
    //       $company_id = self::createEmptyRow('company');
    //       $data = mCompany::getFakeData($user_id, $company_id, $address_id);
    //       mCompany::update($data);

    //       $data = array();
    //       $metadata_id = self::createEmptyRow('metadata');
    //       $data = mMetadata::getFakeData($user_id, $metadata_id);
    //       mMetadata::update($data);
    //     }
    //   }
    // }



    //END FUNCTION
  }

  public static function deleteById(string $table, int $id)
  {
    try {
      $query = "DELETE FROM `$table` WHERE `id`=:id LIMIT 1";
      $dB = static::getdb();
      $stmt = $dB->prepare($query);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);

      return $stmt->execute();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }

  //
  //END CLASS
}
