<?php

  ini_set('display_errors','On');
  error_reporting(E_ALL);

  define('DATABASE', 'kn272');
  define('USERNAME', 'kn272');
  define('PASSWORD', 'KYhRX7n1z');
  define('CONNECTION', 'sql.njit.edu');

  //echo 'hello world<br>';

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

  class model {
     protected $tableName;

     public function save() {

     }

     public function insert() {
        $db = dbConn::getConnection();
	$tableName = $this->tableName;
	$array = get_object_vars($this);
	array_pop($array);
	//print_r($array);
	$heading = array_keys($array);	
	$columnString = implode(',',$heading);
	$valueString = ':' . implode(',:',$heading);
	$sql = 'INSERT INTO accounts (' . $columnString . ') VALUES (' . $valueString . ')';
        //echo $sql;
        $statement = $db->prepare($sql);
	$statement->execute($array);
	//echo 'insert done successfully!<br>';
     }

     public function update($id) {
        $db = dbConn::getConnection();
        $tableName = $this->tableName;
        $array = get_object_vars($this);
        array_pop($array);
        //print_r($array);
        $heading = array_keys($array);
	//print_r($heading);
	$setArray = array();
	$setValue = array();
	foreach($array as $key => $value) {
           if($value!='') {
              array_push($setValue, $key . '=' . ':' . $key);
	      $setArray[$key] = $value;
	   }
	}
	//print_r($setArray);
	$str = implode(',',$setValue);
	$sql = 'UPDATE ' . $tableName . ' SET ' . $str . ' WHERE id=' . $id;
	$statement = $db->prepare($sql);
	$statement->execute($setArray);
	//echo '<br> update done!';
     }

     public function delete($id) {
        $db = dbConn::getConnection();
	$tableName = $this->tableName;
	$sql = 'DELETE FROM ' . $tableName . ' WHERE id=' . $id;
	$statement = $db->prepare($sql);
	$statement->execute();
	echo 'row where id = ' . $id . ' deleted successfully!<br>';
     }

     public function getHeading() {
        $tableName = $this->tableName;
	$sql = 'SHOW COLUMNS FROM ' . $tableName;
        $db = dbConn::getConnection();
	$statement = $db->prepare($sql);
	$statement->execute();
	$heading = $statement->fetchAll(PDO::FETCH_COLUMN);
	return $heading;
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

  class table {
     static public function createTable($heading,$rows) {
     $table = NULL;
     $table .= "<table border = 1>";
     foreach ($heading  as $head) {
        $table .= "<td>$head</td>";
     }   
     foreach ($rows as $row) {
        $table .= "<tr>";
        foreach ($row as $column) {
	   $table .= "<td>$column</td>";
        }
        $table .= "</tr>";
     }
     $table .= "</table>";
     echo $table;
     }
  }
  
  accounts::create();
  $records = accounts::findAll();
  $record = accounts::findOne(2);
  $acc1 = new account();
  $heading = $acc1->getHeading();
  echo '<h1>findAll() using accounts</h1>';
  echo table::createTable($heading,$records);
  echo '<h1>findOne() using accounts</h1>';
  echo table::createTable($heading,$record);
  $acc1->fname = 'king';
  $acc1->lname = 'kong';
  $acc1->insert();
  $arr = accounts::findOne(1016);
  echo '<h1>Insert() using accounts with values fname=king & lname=kong';
  echo table::createTable($heading,$arr);
  $acc1->phone = '1234567';
  $acc1->update(1016);
  $arr = accounts::findOne(1016);
  echo '<h1>Update() using accounts with value phone=1234567 where id=1016';
  echo table::createTable($heading,$arr);
?>
