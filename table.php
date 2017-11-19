<?php
  class table {
     static public function createTable($heading,$rows) {
     $table = NULL;
     $table .= "<table border = 1>";
     foreach ($heading  as $head) {
        $table .= "<th>$head</th>";
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
?>