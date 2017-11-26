<?php

  ini_set('display_errors','On');
  error_reporting(E_ALL);
  
/*  include 'dbConn.php';
  include 'collection.php';
  include 'model.php';
  include 'sqlFunctions.php';
  include 'table.php';
*/
  class classLoader {
     public static function autoload($class) {
        //$toLoad = str_replace('\\','/',$class);
        include 'classes/' . $class . '.php';
     }
  }
  spl_autoload_register(array('classLoader', 'autoload'));

  
  accounts::create();
  $records = accounts::findAll();
  $record = accounts::findOne(2);
  $acc1 = new account();
  $heading = $acc1->getHeading();
  echo '<h1>findAll() using accounts</h1>';
  echo table::createTable($heading,$records);
  echo '<hr>';

  echo '<h1>findOne() using accounts where id = 2 </h1>';
  echo table::createTable($heading,$record);
  echo '<hr>';

  $acc1->fname = 'king';
  $acc1->lname = 'kong';
  $acc1->insert();
  $arr = accounts::findOne(1016);
  echo '<h1>Insert() using accounts with values fname=king & lname=kong';
  echo table::createTable($heading,$arr);
  echo '<hr>';

  $acc1->phone = '1234567';
  $acc1->update(1016);
  $arr = accounts::findOne(1016);
  echo '<h1>Update() using accounts with value phone=1234567 where id=1016';
  echo table::createTable($heading,$arr);
  echo '<hr>';

  $acc1->delete(9);
  $arr = accounts::findAll();
  echo '<h1>delete() using accounts where id = 9</h1>';
  echo table::createTable($heading,$arr);
  echo '<hr>';

  todos::create();
  $records = todos::findAll();
  $todo1 = new todo();
  $heading = $todo1->getHeading();
  echo '<h1>findAll() using todos</h1>';
  echo table::createTable($heading,$records);
  echo '<hr>';

  $todo1->ownerid = '2';
  $todo1->message = 'submit php program';
  $todo1->isdone = '0';
  $todo1->id = '1000';
  $todo1->save();
  $arr = todos::findAll();
  echo '<h1>save() using todos with value ownerid=2 where id=1000</h1>';
  echo table::createTable($heading,$arr);
  echo '<hr>';
?>
