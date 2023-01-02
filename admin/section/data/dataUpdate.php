<?php 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include("../../../template/header.php");
include("../../config/database.php"); 
include("../template/logged.php");

$user_header = [
    "Nombre",
    "Apellidos",
    "Direccion",
    "Ciudad",
    "Departamento",
    "Pais",
    "Telefono",
];
$user_col = [
    "UserFirstName",
    "UserLastName",
    "UserAddress",
    "UserCity",
    "UserState",
    "UserCountry",
    "UserPhone",
];

function postData($user_header,$user_col,$conection){
    if($_POST){
        $action = $_POST["action"]; 
        $column = $_POST["COLUMN"];
        $data = $_POST["data"];
        unset($_POST);

        if(!($action == "UPDATE" && isset($column))){
            $_SESSION['status'] = "Fallo en el servidor.";
            $_SESSION['alert'] = "alert-danger";
            header("Location:".$_SERVER['REQUEST_URI']);
            die();
            return ""; 
        }
        if(empty($data)){
            $_SESSION['status'] = "No se envio ningun dato.";
            $_SESSION['alert'] = "alert-danger";
            header("Location:".$_SERVER['REQUEST_URI']);
            die();
            return ""; 
        }
        $colKey = array_keys($user_header,$_GET["label"]);
        $table = "UPDATE Users SET " .$column. "=:data WHERE UserID=:id";
        $SQLSentence = $conection->prepare($table);
        $SQLSentence->bindParam(':data',$data);
        $SQLSentence->bindParam(':id',$_SESSION["UserID"]);
        $SQLSentence->execute();
        $_SESSION['status'] = $user_header[$colKey[0]]." Actualizado Correctamente.";
        $_SESSION['alert'] = "alert-success";
        header("Location:dataView.php");
        die();
        return ""; 
    }
    return ""; 
}



function getData($user_header,$user_col,$conection){
    if($_GET){
        if(!(isset($_GET["label"]))){
            return "";
        }
        if(!(in_array($_GET["label"],$user_header))){
            return "";
        }
        $colKey = array_keys($user_header,$_GET["label"]);
        $table = "SELECT ".$user_col[$colKey[0]]." FROM Users WHERE UserID=:id";
        $SQLSentence = $conection->prepare($table);
        $SQLSentence->bindParam(':id',$_SESSION["UserID"]);
        $SQLSentence->execute();
        $productDb = $SQLSentence->fetch(PDO::FETCH_LAZY);
        return $colKey;
    }
}
postData($user_header,$user_col,$conection);
$colKey = getData($user_header,$user_col,$conection);

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
                                <input required type="text"  name="data" value="" placeholder="">
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