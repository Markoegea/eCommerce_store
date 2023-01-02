<?php 
if(!(isset($_SESSION["User"]) && $_SESSION["User"] == "ok" && isset($_SESSION["UserID"]))){
    header("Location:../close.php");
}
?>