<?php
$conn = pg_connect("dbname=postgres user=postgres password=1234");
if (!$conn) {
  die("Cannot connect to the database");
}
?>