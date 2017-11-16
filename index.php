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
        $resultSet = sqlFunctions::query($sql);
	print_r($resultSet);
     }

     static public function findOne($id) {
        $table_name = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
        $resultSet = sqlFunctions::query($sql);
        print_r($resultSet($id));
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

     static public function save() {

     }

     static public function insert() {

     }

     static public function update() {

     }

     static public function delete() {

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
     public $ownermail;
     public $ownerid;
     public $createddate;
     public $duedate;
     public $message;
     public $isdone;

     public function __construct() {
        $this->tableName = 'todos';
     }
  }

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
  }
  
  accounts::create();
  $records = accounts::findAll(); 
?>
