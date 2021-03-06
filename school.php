<?php

// include_once("../config.php");

// if(!isset($_GET['term'])) die ('Missing required parameter');

// if(! isset($_COOKIE[session_name()])){
//     die("Must be logged in")
// }

// session_start();

// if(! isset ($_SESSION['user_id'])){
//     die("Access Denied");
// }

include("connection.php");

header('Content-Type: application/json; charset=utf-8');
$term = $_GET['term'];
error_log("looking up typehead term=".$term);

$stmt = $conn->prepare('SELECT name FROM Institution WHERE name LIKE :prefix');
$stmt->execute(array( ':prefix' => $_REQUEST['term']."%"));
$retval = array();
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
  $retval[] = $row['name'];
}

echo(json_encode($retval, JSON_PRETTY_PRINT));



?>