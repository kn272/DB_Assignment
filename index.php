<?php

  ini_set('display_errors','On');
  error_reporting(E_ALL);

  define('DATABASE', 'kn272');
  define('USERNAME', 'kn272');
  define('PASSWORD', 'KYhRX7n1z');
  define('CONNECTION', 'sql.njit.edu');

  echo 'hello world<br>';
/*
  try {
     $db = new PDO( 'mysql:host=' . CONNECTION . ';dbname=' . DATABASE, USERNAME, PASSWORD );
     // $db = new PDO("mysql:host=sql.njit.edu;dbname=kn272,kn272,KYhRX7n1z");
     $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
     echo 'Connected successfully<br>';
  }
  catch (PDOException $e) {
     echo "Connection Error: " . $e->getMessage();
  }
*/

  class dbConn{
     protected static $db;

     private function __construct() {
        try {
           self::$db = new PDO( 'mysql:host=' . CONNECTION . ';dbname=' . DATABASE, USERNAME, PASSWORD );
	   //self::$db = new PDO("mysql:host=sql.njit.edu;dbname=kn272,kn272,KYhRX7n1z");
	   self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	   echo 'Connected successfully<br>';
        }
	catch (PDOException $e) {
           echo "Connection Error: " . $e->getMessage();
	}
     }

     public static function getConnection() {
        if (!self::$db) {
           new dbConn();
	}

	return self::$db;
     } 
  }

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
        //$resultSet = sqlFunctions::query($sql);
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
	return $resultSet[$id];
        //$resultSet = sqlFunctions::query($sql);
        //print_r($resultSet($id));
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

  class model {
     protected $tableName;

     public function save() {

     }

     public function insert() {
        $db = dbConn::getConnection();
	$tableName = $this->tableName;
	$array = get_object_vars($this);
	array_pop($array);
	print_r($array);
	$heading = array_keys($array);	
	$columnString = implode(',',$heading);
	$valueString = ':' . implode(',:',$heading);
	$sql = 'INSERT INTO accounts (' . $columnString . ') VALUES (' . $valueString . ')';
        //echo $sql;
        $statement = $db->prepare($sql);
	$statement->execute($array);
	echo 'insert done successfully!<br>';
     }

     public function update($id) {
        $db = dbConn::getConnection();
        $tableName = $this->tableName;
        $array = get_object_vars($this);
        array_pop($array);
        print_r($array);
        $heading = array_keys($array);
        $columnString = implode(',',$heading);
        $valueString = ':' . implode(',:',$heading);
	$sql = 'UPDATE ' . $tableName . 'SET ';
	$statement = $db->prepare();
	$statement->execute();
     }

     public function delete($id) {
        $db = dbConn::getConnection();
	$tableName = $this->tableName;
	$sql = 'DELETE FROM ' . $tableName . ' WHERE id=' . $id;
	$statement = $db->prepare($sql);
	$statement->execute();
	echo 'row where id = ' . $id . ' deleted successfully!<br>';
     }
  }

  class account extends model {
     public $id;
     public $email;
     public $fname;
     public $lname;
     public $phone;
     public $birthday;
     public $gender;
     public $password;
     

     public function __construct() {
        $this->tableName = 'accounts';
     }

  }

  class todo extends model {
     public $id;
     public $owneremail;
     public $ownerid;
     public $createddate;
     public $duedate;
     public $message;
     public $isdone;

     public function __construct() {
        $tableName = 'todos';
     }
  }

/*
  class sqlFunctions {
     static public function query($sql) {
        $db = dbConn::getConnection();
	$statement = $db->prepare($sql);
	$statement->execute();
	$class = static::$modelName;
	$statement->setFetchMode(PDO::FETCH_CLASS, $class);
	$recordSet = $statement->fetchAll();
	return $recordSet;
     }
  }*/
  
  accounts::create();
  $records = accounts::findAll();
  print_r($records);

  $record = accounts::findOne(0);
  print_r($record);

  //account::delete(1);

  $acc1 = new account();
  $acc1->fname = 'kishore';
  $acc1->lname = 'reddy';
  $acc1->insert();
  $acc1->delete(1);

  $todo1 = new todo();
  $todo1->ownerid = '007';
  $todo1->insert();
?>
