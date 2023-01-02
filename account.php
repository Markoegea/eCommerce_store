<?php include("template/header.php"); ?>
<?php 

if(isset($_SESSION['User'])){
    if($_SESSION['User'] =="ok"){
        header('Location:admin/section/account.php');
    }
}
include("admin/config/database.php");

$action = isset($_POST["action"]) ? $_POST["action"] : "";

switch($action){
    case "login";
        $txtEmail = isset($_POST["email"]) ? filter_var($_POST["email"], FILTER_SANITIZE_EMAIL): "";
        $txtPassword = isset($_POST["password"]) ? $_POST["password"] : "";
        if ($txtEmail == "" || $txtPassword == ""){
            $status = "Faltan campos por llenar.";
            $alert = "alert-danger";
            break;
        }

        $SQLSentence = $conection->prepare("SELECT UserPassword, UserID FROM Users WHERE UserEmail=:email");
        $SQLSentence->bindParam(':email',$txtEmail);
        $SQLSentence->execute();
        $productDb = $SQLSentence->fetch(PDO::FETCH_LAZY);

        if ($productDb == FALSE)
        {
            $status = "Correo no registrado.";
            $alert = "alert-danger";
            break;
        }
        
        if (!($txtPassword == $productDb["UserPassword"])){
            $status = "Contraseña incorrecta";
            $alert = "alert-danger";
            break;
        }
        $_SESSION['User'] = "ok";
        $_SESSION["UserID"] = $productDb["UserID"];
        header('Location:admin/section/account.php');
        break;

    case "register";
        $txtName = isset($_POST["name"]) ? htmlentities($_POST["name"]) : "";
        $txtSurname = isset($_POST["surname"]) ? htmlentities($_POST["surname"]) : "";
        $txtEmail = isset($_POST["email"]) ? filter_var($_POST["email"], FILTER_SANITIZE_EMAIL): "";
        $txtPassword = isset($_POST["password"]) ? $_POST["password"] : "";
        $conf_Password = isset($_POST["conf_password"]) ? $_POST["conf_password"] : "";
        
        if ($txtPassword != $conf_Password){
            $status = "Las contraseñas no coinciden.";
            $alert = "alert-danger";
            break;
        }
        if ($txtName != "" && $txtSurname != "" && $txtEmail != "" && $txtPassword != ""){
            $SQLSentence = $conection->prepare("
            INSERT INTO Users (UserEmail,UserPassword,UserFirstName,UserLastName) 
            VALUES (:email, :password, :firstName, :lastName);
            ");
            $SQLSentence->bindParam(":email",$txtEmail);
            $SQLSentence->bindParam(":password",$txtPassword);
            $SQLSentence->bindParam(":firstName",$txtName);
            $SQLSentence->bindParam(":lastName",$txtSurname);
            $SQLSentence->execute();
            $status = "Registro exitoso";
            $alert = "alert-success";
            break;
        }
        $status = "Faltan campos por llenar.";
        $alert = "alert-danger";
        break;
}
?>

<!------------account-page----------->
<div class="info">
    <div class="container">
        <div class="form-container">
            
            <?php if(isset($status)): ?>
                <div class="alert <?=(isset($alert) ? $alert :"")?>" role="alert">
                    <?=  $status ?>
                </div>
            <?php endif; ?>
            
            <div class="form-btn">
                <span onclick="login()">Login</span>
                <span onclick="register()">Register</span>
                <hr id="Indicator">
            </div>

            <form id="LoginForm" method="post">
                <input type="text"  name="email" placeholder="Email">
                <input type="password"  name= "password" placeholder="Contraseña">
                <button type="submit" name="action" value = "login" class="btn">Entrar</button>
                <a href="">Olvidaste la contraseña</a>
            </form>

            <form id="RegForm" method="post">
                <input type="text"  name="name" placeholder="Nombres">
                <input type="text"  name="surname" placeholder="Apellidos">
                <input type="email"  name="email" placeholder="Email">
                <input type="password"  name="password" placeholder="Contraseña">
                <input type="password"  name="conf_password" placeholder="Confirme la Contraseña">
                <button type="submit" name="action" value= "register" class="btn">Register</button>
            </form>
        </div>
    </div>
</div>

<script src="js/forms.js"></script>

<?php include("template/footer.php"); ?>