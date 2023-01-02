<?php 
include("../../../template/header.php");
include("../../config/database.php"); 
include("../template/logged.php");

$SQLSentence = $conection->prepare("
SELECT UserEmail FROM Users WHERE UserID=:id
");
$SQLSentence->bindParam(':id',$_SESSION["UserID"]);
$SQLSentence->execute();
$productDb = $SQLSentence->fetch(PDO::FETCH_LAZY);

$user_header = [
    "Email",
    "Contraseña"
];
$user_col = [
    "UserEmail",
    "UserPassword",
];

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
            <p>No info</p>
            
            <div class="data-container">

            <?php if(isset($status)): ?>
                <div class="alert <?=(isset($alert) ? $alert :"")?>" role="alert">
                    <?=  $status ?>
                </div>
            <?php endif; ?>

                    <?php for($i = 0; $i < count($user_header); $i++): ?>
                        <a href="privateDataUpdate.php?label=<?=$user_header[$i]?>" class="sub-menu-link">
                            <div class="sub-menu">
                                <div class="user-info">
                                    <div class="row">
                                        <div class="col-2 data">
                                            <p for="txtNombre"><?= $user_header[$i] ?>:</p>
                                        </div>
                                        <div class="col-2 data">
                                            <?php if($user_col[$i] == "UserPassword"): ?>
                                                <p>*******</p>
                                            <?php endif; ?>
                                            <?php if($user_col[$i] == "UserEmail"): ?>
                                                <p><?=$productDb[$user_col[$i]]  ? strtoupper($productDb[$user_col[$i]]) : "Falta Dato"?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endfor; ?>
                    <a href="deleteAccount.php" class="sub-menu-link">
                        <div class="sub-menu">
                            <div class="user-info">
                                <div class="row">
                                    <p for="txtNombre">BORRAR CUENTA</p>
                                </div>
                            </div>
                        </div>
                    </a>
            </div>
        </div>
    </div>
</div>
<?php include("../../../template/footer.php") ?>