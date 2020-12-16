<?php

$servername = "localhost";
$username = "root";
$password = "mysql";

try{
    $conn = new PDO("mysql:host=$servername;dbname=coursera",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo $e.getMessage();
}

?>