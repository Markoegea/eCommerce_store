<?php 

session_start();
include("../../config/database.php"); 
include("../template/logged.php");

if (isset($_SESSION) && isset($_SESSION["UserID"]) && $_SESSION['User'] == "ok"){
    $SQLSentence = $conection->prepare("SELECT ProductImagesURL FROM Products WHERE UserID=:id");
    $SQLSentence->bindParam(':id',$_SESSION["UserID"]);
    $SQLSentence->execute();
    $productDb = $SQLSentence->fetch(PDO::FETCH_LAZY);
    if(isset($productDb["ProductImagesURL"]) && ($productDb["ProductImagesURL"] != ["no_image.jpg"])){
       $imagesList = explode(", ",$productDb["ProductImagesURL"]);
       foreach ($imagesList as $image){
           if(file_exists("../../../images/".$image)){
               unlink("../../../images/".$image);
           }
       }
    }

    $SQLSentence = $conection->prepare("SELECT UserImageURL FROM Users WHERE UserID=:id");
    $SQLSentence->bindParam(':id',$_SESSION["UserID"]);
    $SQLSentence->execute();
    $userDB = $SQLSentence->fetch(PDO::FETCH_LAZY);
    if(isset($userDB["UserImageURL"]) && ($userDB["UserImageURL"] != ["no_image.jpg"])){
        $image = $userDB["UserImageURL"];
        if(file_exists("../../../images/".$image)){
            unlink("../../../images/".$image);
        }
    }

    $table = "DELETE FROM Users WHERE UserID=:id";
    $SQLSentence = $conection->prepare($table);
    $SQLSentence->bindParam(':id',$_SESSION["UserID"]);
    $SQLSentence->execute();
    header("Location:../close.php");
}
header("Location:../close.php");
?>