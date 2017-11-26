<?php
  //namespace 'classes\model';  
    
  abstract class model {
     protected $tableName;

     public function save() {
        if ($this->id == '') {
	   $this->insert();
	}
	else {	   
           $this->update($this->id);
	}
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
	$sql = 'INSERT INTO ' . $tableName . ' (' . $columnString . ') VALUES (' . $valueString . ')';
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
	//echo 'row where id = ' . $id . ' deleted successfully!<br>';
     }

     public function getHeading() {
        $tableName = $this->tableName;
	$sql = 'SHOW COLUMNS FROM ' . $tableName;
        $db = dbConn::getConnection();
	$statement = $db->prepare($sql);
	$statement->execute();
	$heading = $statement->fetchAll(PDO::FETCH_COLUMN);
	//echo $sql . '<br>';
	return $heading;
     }
  }
?>