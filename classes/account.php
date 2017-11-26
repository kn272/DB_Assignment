<?php 
  /*namespace classes\account;
  require 'model.php';
  use 'classes';*/
  final class account extends model {
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
?>