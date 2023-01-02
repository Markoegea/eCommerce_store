<?php 
session_start();
if(!(isset($_SESSION["User"]) && $_SESSION["User"] == "ok" && isset($_SESSION["UserID"]))){
    header("Location:close.php");
}
include("../config/database.php");

$SQLSentence = $conection->prepare("
INSERT INTO Cart(UserID, ProductID, Quantity) VALUES (:Uid ,:Pid, 1);
");
$SQLSentence->bindParam(":Uid",$_SESSION["UserID"]);
$SQLSentence->bindParam(":Pid",$_GET["id"]);
//$SQLSentence->bindParam(":images",$stringImages);
$SQLSentence->execute();
header("Location:../../cart.php");
?>