<?php include("template/header.php"); ?>
    <?php 
        include("admin/config/database.php");
        $SQLSentence = $conection->prepare("SELECT 
        UserEmail, 
        UserFirstName, 
        UserLastName, 
        UserAddress, 
        UserCity, 
        UserState, 
        UserCountry, 
        UserRegistrationDate, 
        UserPhone, 
        UserImageURL 
        FROM Users WHERE UserID=:id");
        $SQLSentence->bindParam(':id',$_GET["id"]);
        $SQLSentence->execute();
        $userDb = $SQLSentence->fetch(PDO::FETCH_LAZY);
    ?>
<div class="info">
    <div class="user-container">
        <div class="profile-box">
                <img src="images/<?=$userDb["UserImageURL"]?>" alt="">          
            <h3> <?=$userDb["UserFirstName"]?> <?=$userDb["UserLastName"]?> </h3>
        </div>
    </div>
    <br>
    <div class="user-container">
        <div class="profile-box">
            <div class="data-container">
                    <div class="sub-menu-wrap">
                        <div class="sub-menu">
                            <div class="user-info">
                                <div class="col-2">
                                    Direccion:
                                </div>
                                <div class="col-2">
                                    <?=$userDb["UserAddress"] ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="sub-menu">
                            <div class="user-info">
                                <div class="col-2">
                                    Ubicacion:
                                </div>
                                <div class="col-2">
                                    <?=$userDb["UserCity"] ?>, <?=$userDb["UserState"] ?>, <?=$userDb["UserCountry"] ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="sub-menu">
                            <div class="user-info">
                                <div class="col-2">
                                    Telefono:
                                </div>
                                <div class="col-2">
                                    <?=$userDb["UserPhone"] ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="sub-menu">
                            <div class="user-info">
                                <div class="col-2">
                                    Email:
                                </div>
                                <div class="col-2">
                                    <?=$userDb["UserEmail"] ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="sub-menu">
                            <div class="user-info">
                                <div class="col-2">
                                    Fecha de registro:
                                </div>
                                <div class="col-2">
                                    <?=$userDb["UserRegistrationDate"] ?>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
            </div>
        </div>
    </div>
</div>
<!-- Poner los solicitudes y productos que tenga el usuario. -->
<?php include("template/footer.php"); ?>