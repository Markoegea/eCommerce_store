<?php 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include("../../../template/header.php");
include("../../config/database.php"); 
include("../template/logged.php");

$user_header = [
    "Email",
    "Contraseña"
];
$user_col = [
    "UserEmail",
    "UserPassword",
];

function postData($user_header,$user_col,$conection){
    if($_POST){
        $action = $_POST["action"]; 
        $column = $_POST["COLUMN"];
        $actual_data = $_POST["actual_data"];
        $new_data = $_POST["new_data"];
        $conf_data = $_POST["conf_data"];
        unset($_POST);
        $colKey = array_keys($user_header,$_GET["label"]);

        if((!($action == "UPDATE" && isset($column))) || empty($actual_data)){
            $_SESSION['status'] = "Fallo en el servidor.";
            $_SESSION['alert'] = "alert-danger";
            header("Location:".$_SERVER['REQUEST_URI']);
            die();
            return ""; 
        }

        if($new_data != $conf_data){
            $_SESSION['status'] = "Los ".$user_header[$colKey[0]]." no coinciden.";
            $_SESSION['alert'] = "alert-danger";
            header("Location:".$_SERVER['REQUEST_URI']);
            die();
            return ""; 
        }

        $table = "SELECT ".$column." FROM Users WHERE UserID=:id";
        $SQLSentence = $conection->prepare($table);
        $SQLSentence->bindParam(':id',$_SESSION["UserID"]);
        $SQLSentence->execute();
        $productDb = $SQLSentence->fetch(PDO::FETCH_LAZY);
        
        if (isset($productDb[$column]) && $productDb[$column] == $actual_data){
            $table = "UPDATE Users SET " .$column. "=:data WHERE UserID=:id";
            $SQLSentence = $conection->prepare($table);
            $SQLSentence->bindParam(':data',$new_data);
            $SQLSentence->bindParam(':id',$_SESSION["UserID"]);
            $SQLSentence->execute();
            $_SESSION['status'] = $user_header[$colKey[0]]." Actualizado Correctamente.";
            $_SESSION['alert'] = "alert-success";
            header("Location:privateDataView.php");
            die();
            return ""; 
        } else{
            $_SESSION['status'] = "El ".$user_header[$colKey[0]]." no coinciden con la del servidor.";
            $_SESSION['alert'] = "alert-danger";
            header("Location:".$_SERVER['REQUEST_URI']);
            die();
            return ""; 
        }
        return ""; 
    }
    return ""; 
}



function getData($user_header,$user_col){
    if($_GET){
        if(!(isset($_GET["label"]))){
            return "";
        }
        if(!(in_array($_GET["label"],$user_header))){
            return "";
        }
        $colKey = array_keys($user_header,$_GET["label"]);
        return $colKey;
    }
}
postData($user_header,$user_col,$conection);
$colKey = getData($user_header,$user_col);

if (isset($_SESSION['status']) && $_SESSION['status'] != ""){
    $status = $_SESSION['status'];
    $_SESSION['status'] = "";
    $alert = $_SESSION['alert'];
    $_SESSION['alert'] = "";
}
?>
<div class="info">
    <div class="user-container">
        <div class="profile-box">

            <img src="../../../images/profile.jpg" alt="">
            <h3>User Unknown</h3>
            <p>Actualiza tu datos personales</p>
            
            <div class="data-container">

            <?php if(isset($status)): ?>
                <div class="alert <?=(isset($alert) ? $alert :"")?>" role="alert">
                    <?=  $status ?>
                </div>
            <?php endif; ?>

                <form method="post">
                    <div class="sub-menu">
                        <div class="user-info">
                            <div class="row">
                                <div class="col-2 data">
                                    <p>Nuevo <?= ($colKey !="") ? $user_header[$colKey[0]] : ""?>:</p>
                                </div>
                                <div class="col-2">
                                    <input hidden type="text" name="COLUMN" value="<?=(isset($colKey)) ? $user_col[$colKey[0]] : ""?>">
                                    <input required type="<?=($user_header[$colKey[0]] == "Contraseña") ? "password": "email"?>"  name="actual_data" value="" placeholder="<?=$user_header[$colKey[0]]?> Actual">
                                    <input required type="<?=($user_header[$colKey[0]] == "Contraseña") ? "password": "email"?>"  name="new_data" value="" placeholder="Nueva <?=$user_header[$colKey[0]]?>">
                                    <input required type="<?=($user_header[$colKey[0]] == "Contraseña") ? "password": "email"?>"  name="conf_data" value="" placeholder="Confirmar <?=$user_header[$colKey[0]]?>">
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="action" value= "UPDATE" class="btn">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include("../../../template/footer.php") ?>