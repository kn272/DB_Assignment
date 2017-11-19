<?php
class collection {

     static public function create() {
        $model = new static::$modelName;
	return $model;
     }  

     static public function findAll() {
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName;
	$db = dbConn::getConnection();
	$statement = $db->prepare($sql);
	$statement->execute();
	$class = static::$modelName;
	$statement->setFetchMode(PDO::FETCH_CLASS,$class);
	$resultSet = $statement->fetchAll();
	return $resultSet;
	//print_r($resultSet);
     }

     static public function findOne($id) {
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
        $db = dbConn::getConnection();
        $statement = $db->prepare($sql);
        $statement->execute();
        $class = static::$modelName;
        $statement->setFetchMode(PDO::FETCH_CLASS,$class);
        $resultSet = $statement->fetchAll();
	return $resultSet;
     }
  }

  class accounts extends collection {

    /* public function construct() {
        static $modelName = 'account';
     }*/
     public  static $modelName = 'account';
  }

  class todos extends collection {
    /* public function construct() {
        static $modelName = 'todo';
     }*/
     public static $modelName = 'todo';
  }
?>
