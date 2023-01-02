<?php include("../../template/header.php") ?>
<?php 
if(!(isset($_SESSION["User"]) && $_SESSION["User"] == "ok" && isset($_SESSION["UserID"]))){
    header("Location:close.php");
}
include("../config/database.php");

function assingName($file,$url){
    $date = new DateTime();

    if (($file =="") || ($url =="")){
        return "no_image.jpg";
    }

    $name = $date->getTimestamp()."_".$file;
    if(move_uploaded_file($url,"../../images/".$name)){
        return $name;
    }
    return "no_image.jpg";
}

if($_POST){
    $urlImage = isset($_FILES["profileImage"]["name"]) ? $_FILES["profileImage"]["tmp_name"] : ["No habia"];
    $SQLSentence = $conection->prepare("UPDATE Users SET UserImageURL=:images WHERE UserID=:id");
    $SQLSentence->bindParam(':id',$_SESSION["UserID"]);
    $stringImages = assingName($_FILES["profileImage"]["name"],$urlImage);
    $SQLSentence->bindParam(':images',$stringImages);
    $SQLSentence->execute();
    header("Location:account.php");
}

$SQLSentence = $conection->prepare("SELECT UserFirstName, UserLastName, UserCity, UserRegistrationDate, UserPhone, UserAddress,UserImageURL 
FROM Users WHERE UserID=:id");
$SQLSentence->bindParam(':id',$_SESSION["UserID"]);
$SQLSentence->execute();
$productDb = $SQLSentence->fetch(PDO::FETCH_LAZY);
if($productDb["UserImageURL"] != NULL){
    $src = "../../images/".$productDb["UserImageURL"];
}else{
    $src = "../../images/profile.jpg";
}
?>
<div class="info">
    <div class="user-container">
        <div class="profile-box">
            <div class="inputFile">
                <label>
                    <img src="<?=$src?>" alt="">
                    <br>
                    <i class="fa fa-2x fa-camera"></i>
                    <form method="post" enctype="multipart/form-data">
                        <input type="file" name="profileImage" id="profileImage">
                        <span id="imageName"></span>
                        <div id="buttonImage"></div>
                    </form>
                    <br>
                </label>
            </div>
            
            <?php if(isset($productDb["UserFirstName"])): ?>
                <h3>Hola, <?=  $productDb["UserFirstName"] ?></h3>
                <p>Bienvenid@, que vamos a hacer hoy?</p>
            <?php endif; ?>
        </div>
    </div>
    <br>
    <div class="user-container">
        <div class="profile-box">
            <div class="data-container">
                <form method="post" enctype="multipart/form-data">
                    <div class="sub-menu-wrap">
                        <div class="sub-menu">
                            <div class="user-info">
                                <a href="requests.php" class="sub-menu-link">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                    <h2>Solicitudes</h2>
                                    <span>></span>
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="sub-menu">
                            <div class="user-info">
                                <a href="products.php" class="sub-menu-link">
                                    <i class="fa-solid fa-store"></i>
                                    <h2>Publicaciones</h2>
                                    <span>></span>
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="sub-menu">
                            <div class="user-info">
                                <a href="data/dataView.php" class="sub-menu-link">
                                    <i class="fa-regular fa-user"></i>
                                    <h2>Editar Perfil</h2>
                                    <span>></span>
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="sub-menu">
                            <div class="user-info">
                                <a href="data/privateDataView.php" class="sub-menu-link">  
                                    <i class="fa-solid fa-lock"></i>  
                                    <h2>Privacidad</h2>
                                    <span>></span>
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="sub-menu">
                            <div class="user-info">
                                <a href="#" class="sub-menu-link">
                                    <i class="fa-solid fa-question"></i>
                                    <h2>Ayuda</h2>
                                    <span>></span>
                                </a>
                            </div>
                        </div>
                        <hr>
                        <div class="sub-menu">
                            <div class="user-info">
                                <a href="close.php" class="sub-menu-link">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                    <h2>Salir</h2>
                                    <span>></span>
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <script>
        //Get the names of the files storaged in the input file and write it in the span
        var images = [];
        document.getElementById("profileImage").onchange = function () {
            for (let i = 0; i < this.files.length; i++){
                images.push(this.files[i].name);
            }
            console.log(images);
            document.getElementById("imageName").innerHTML = images.join("\n");
            document.getElementById("buttonImage").innerHTML='<button type="submit" name = "action" value = "UPDATE" class="btn btn-info">Subir</button>';
            images = [];
        };
    </script>
<?php include("../../template/footer.php") ?>