<?php
$servername="localhost";
$db="root";
$pass="";
$dbName="ssipnew";
$conn=mysqli_connect($servername, $db, $pass, $dbName);
    if(!$conn){
        die("Connection Failed: ". mysqli_connect_error());
    }
?>