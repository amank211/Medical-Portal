<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '@aman22#');
define('DB_NAME', 'Medical_Portal');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//create database "Medical-portal"
$query = file_get_contents("create-database.sql");						//get sql query from create-databse.sql
mysqli_multi_query($link, $query);
mysqli_close($link);

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$query = file_get_contents("create-table.sql");
$stmt = mysqli_multi_query($link, $query);
mysqli_close($link);

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


?>