<?php


namespace Modules\Blog\Models;

use PDO;
use PDOException;

use App\Core\Database;

use App\Core\NewException;
use RuntimeException;



class mPosts extends Database
{

  public function __construct()
  {
    parent::__construct();
  }


  public static function setTable()
  {
    try {
      $query = "CREATE TABLE IF NOT EXISTS `posts` ( 
        `id` SERIAL PRIMARY KEY,
        `title` varchar(255) NOT NULL,
        `slug` varchar(255) NOT NULL,
        `status` enum('draft','published','archived') NOT NULL,
        `date_at` VARCHAR(50),
        `author` varchar(255) NOT NULL,
        `avatar` VARCHAR(255),
        `img_landscape` varchar(255),
        `img_portrait` varchar(255),
        `description` TEXT,
        `content` LONGTEXT,
        `acc_id` BIGINT UNSIGNED,
        FOREIGN KEY (acc_id) REFERENCES accounts(id)
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
    $query = "INSERT INTO `posts` (
      `id`, 
      `title`,
      `slug`, 
      `status`,
      `date_at`, 
      `author`,
      `avatar`, 
      `img_landscape`,
      `img_portrait`,
      `description`,
      `content`,
      `acc_id`
      )
    VALUES (
      :id, 
      :title,
      :slug, 
      :status,
      :date_at, 
      :author,
      :avatar, 
      :img_landscape,
      :img_portrait,
      :description,
      :content,
      :acc_id
      )";

    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':id', null, PDO::PARAM_NULL);
    $stmt->bindValue(':acc_id', $args['acc_id'], PDO::PARAM_INT);
    $stmt->bindValue(':title', $args['title'], PDO::PARAM_STR);
    $stmt->bindValue(':slug', $args['slug'], PDO::PARAM_STR);
    $stmt->bindValue(':status', $args['status'], PDO::PARAM_STR);
    $stmt->bindValue(':date_at', $args['date_at'], PDO::PARAM_STR);
    $stmt->bindValue(':author', $args['author'], PDO::PARAM_STR);
    $stmt->bindValue(':avatar', $args['avatar'], PDO::PARAM_STR);
    $stmt->bindValue(':img_landscape', $args['img_landscape'], PDO::PARAM_STR);
    $stmt->bindValue(':img_portrait', $args['img_portrait'], PDO::PARAM_STR);
    $stmt->bindValue(':description', $args['description'], PDO::PARAM_LOB);
    $stmt->bindValue(':content', $args['content'], PDO::PARAM_LOB);
    try {
      $stmt->execute();
      return $dB->lastInsertId();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public static function createEmptyBlog(array $args)
  {


    $query = "INSERT INTO `posts` ( 
      `id`, 
      `acc_id`, 
      `date_at`, 
      `status`, 
      `author`, 
      `avatar`,
      `img_landscape`,
      `img_portrait`
      )
    VALUES ( 
      :id, 
      :acc_id, 
      :date_at, 
      :status, 
      :author, 
      :avatar,
      :img_landscape,
      :img_portrait
      )";


    $dB = static::getdb();
    $stmt = $dB->prepare($query);

    $stmt->bindValue(':id', NULL, PDO::PARAM_NULL);
    $stmt->bindValue(':acc_id', $args['acc_id'], PDO::PARAM_INT);

    $stmt->bindValue(':status', $args['status'], PDO::PARAM_STR);
    $stmt->bindValue(':date_at', $args['date_at'], PDO::PARAM_STR);

    $stmt->bindValue(':author', $args['author'], PDO::PARAM_STR);
    $stmt->bindValue(':avatar', $args['avatar'], PDO::PARAM_STR);

    $stmt->bindValue(':img_landscape', $args['img_landscape'], PDO::PARAM_STR);
    $stmt->bindValue(':img_portrait', $args['img_portrait'], PDO::PARAM_STR);

    try {
      $stmt->execute();
      return $dB->lastInsertId();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public static function readByStatus(string $status)
  {
    try {
      $query = "SELECT * FROM `posts` WHERE `status` = :status";
      $dB = static::getdb();
      $stmt = $dB->prepare($query);
      $stmt->bindValue(':status', $status, PDO::PARAM_STR);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }

  public static function readBySlug(string $slug)
  {
    $query = "SELECT * FROM `posts` WHERE `slug` = :slug LIMIT 1";
    $dB = static::getdb();
    $stmt = $dB->prepare($query);
    $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    try {
      $stmt->execute();
      return $stmt->fetchAll();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }

  public static function countByStatus(string $status)
  {
    try {
      $query = "SELECT * FROM `posts` WHERE `status` = :status";
      $dB = static::getdb();
      $stmt = $dB->prepare($query);
      $stmt->bindValue(':status', $status, PDO::PARAM_STR);

      $stmt->execute();
      return $stmt->rowCount();
    } catch (PDOException $e) {
      $e->getMessage();
      return false;
    }
  }


  public static function update($args = array())
  {
    try {
      $query = "UPDATE `posts` SET 
        `title`=:title,
        `slug`=:slug, 
        `status`=:status,
        `date_at`=:date_at, 
        `author`=:author,
        `avatar`=:avatar,
        `img_landscape`=:img_landscape,
        `img_portrait`=:img_portrait,
        `description`=:description,
        `content`=:content,
        `acc_id`=:acc_id
      WHERE `id` = :id";

      $dB = static::getdb();
      $stmt = $dB->prepare($query);

      $stmt->bindValue(':id', $args['id'], PDO::PARAM_INT);
      $stmt->bindValue(':acc_id', $args['acc_id'], PDO::PARAM_INT);
      $stmt->bindValue(':title', $args['title'], PDO::PARAM_STR);
      $stmt->bindValue(':slug', $args['slug'], PDO::PARAM_STR);
      $stmt->bindValue(':status', $args['status'], PDO::PARAM_STR);
      $stmt->bindValue(':date_at', $args['date_at'], PDO::PARAM_STR);
      $stmt->bindValue(':author', $args['author'], PDO::PARAM_STR);
      $stmt->bindValue(':avatar', $args['avatar'], PDO::PARAM_STR);
      $stmt->bindValue(':img_landscape', $args['img_landscape'], PDO::PARAM_STR);
      $stmt->bindValue(':img_portrait', $args['img_portrait'], PDO::PARAM_STR);
      $stmt->bindValue(':description', $args['description'], PDO::PARAM_LOB);
      $stmt->bindValue(':content', $args['content'], PDO::PARAM_LOB);


      return $stmt->execute();
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }




  //
  //END CLASS
}
