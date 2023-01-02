<?php 
$host='localhost';
$db='ecommerce_db';
$user='programmer';
$password='!8lFhZ2W^8Vy';
//$status = "";

try {
    $conection = new PDO("mysql:host=$host;dbname=$db",$user,$password);
    //$status = "Connection Succesful";

} catch (Exception $ex) {
    $status = $ex;
}
?>