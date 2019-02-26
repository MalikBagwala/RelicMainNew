<?php
require('database.php');
$q = $_REQUEST['products'];

$query = pg_query($conn,"SELECT pname FROM smartphone WHERE pname LIKE '%$q%'");
if(!$query){
  echo("No suggestions");
}else{
  $name = pg_fetch_assoc($query);
  echo($name['pname']);
}

?>