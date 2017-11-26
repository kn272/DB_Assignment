<?php
  //namespace 'classes\dbConn';  
  define('DATABASE', 'kn272');
  define('USERNAME', 'kn272');
  define('PASSWORD', 'KYhRX7n1z');
  define('CONNECTION', 'sql.njit.edu');
  final class dbConn{
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
?>