<?php 
include("../../template/header.php");

if(!(isset($_SESSION["User"]) && $_SESSION["User"] == "ok" && isset($_SESSION["UserID"]))){
    header("Location:close.php");
}

include("../config/database.php");

//TODO: Satinizar los datos, PERRO
$userID = isset($_SESSION["UserID"]) ? $_SESSION["UserID"] : "";
$txtID = isset($_POST["txtID"]) ? $_POST["txtID"] : "";
$txtNombre = isset($_POST["txtNombre"]) ? $_POST["txtNombre"] : "";
$txtDescription = isset($_POST["txtDescription"]) ? $_POST["txtDescription"] : "";
$images = isset($_FILES["fileImages"]["name"]) ? $_FILES["fileImages"]["tmp_name"] : ["No habia"];
$action = isset($_POST["action"]) ? $_POST["action"] : "";


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


switch($action){
    case "CREATE";
        $SQLSentence = $conection->prepare("
            INSERT INTO Requests(UserID, RequestName, RequestLongDesc, RequestCategoryID, RequestImagesURL) 
            VALUES (:id ,:name, :description, 1, :images);
        ");
        $SQLSentence->bindParam(":id",$userID);
        $SQLSentence->bindParam(":name",$txtNombre);
        $SQLSentence->bindParam(":description",$txtDescription);
        $imageStorage = array_map("assingName",$_FILES["fileImages"]["name"],$_FILES["fileImages"]["tmp_name"]);
        $stringImages = implode(", ",$imageStorage);
        $SQLSentence->bindParam(":images",$stringImages);
        $SQLSentence->execute();
        header("Location:requests.php");
        break;

    case "UPDATE";
        $SQLSentence = $conection->prepare("UPDATE Requests SET RequestName=:name, RequestLongDesc=:description WHERE RequestID=:id");
        $SQLSentence->bindParam(':id',$txtID);
        $SQLSentence->bindParam(':name',$txtNombre);
        $SQLSentence->bindParam(':description',$txtDescription);
        $SQLSentence->execute();

        if(!empty($images[0])){
            $SQLSentence = $conection->prepare("SELECT RequestImagesURL FROM Requests WHERE RequestID=:id");
            $SQLSentence->bindParam(':id',$txtID);
            $SQLSentence->execute();
            $requestDb = $SQLSentence->fetch(PDO::FETCH_LAZY);
            if(isset($requestDb["RequestImagesURL"]) && ($requestDb["RequestImagesURL"] != ["no_image.jpg"])){
                $imagesList = explode(", ",$requestDb["ProductImagesURL"]);
                foreach ($imagesList as $image){
                    if(file_exists("../../images/".$image)){
                        unlink("../../images/".$image);
                    }
                }
            }

            $SQLSentence = $conection->prepare("UPDATE Requests SET RequestImagesURL=:images WHERE RequestID=:id");
            $SQLSentence->bindParam(':id',$txtID);
            $imageStorage = array_map("assingName",$_FILES["fileImages"]["name"],$_FILES["fileImages"]["tmp_name"]);
            $stringImages = implode(", ",$imageStorage);
            $SQLSentence->bindParam(':images',$stringImages);
            $SQLSentence->execute();
        }
        header("Location:requests.php");
        break;

    case "DELETE";
        $SQLSentence = $conection->prepare("SELECT RequestImagesURL FROM Requests WHERE RequestID=:id");
        $SQLSentence->bindParam(':id',$txtID);
        $SQLSentence->execute();
        $requestDb = $SQLSentence->fetch(PDO::FETCH_LAZY);
        if(isset($requestDb["RequestImagesURL"]) && ($requestDb["RequestImagesURL"] != ["no_image.jpg"])){
            $imagesList = explode(", ",$requestDb["RequestImagesURL"]);
            foreach ($imagesList as $image){
                if(file_exists("../../images/".$image)){
                    unlink("../../images/".$image);
                }
            }
        }

        $SQLSentence = $conection->prepare("DELETE FROM Requests WHERE RequestID=:id");
        $SQLSentence->bindParam(':id',$txtID);
        $SQLSentence->execute();
        header("Location:requests.php");
        break;

    case "SELECT";
        $SQLSentence = $conection->prepare("SELECT * FROM Requests WHERE RequestID=:id");
        $SQLSentence->bindParam(':id',$txtID);
        $SQLSentence->execute();
        $requestDb = $SQLSentence->fetch(PDO::FETCH_LAZY);
        break;

    case "CANCEL";
        header("Location:requests.php");
        break;
}

$SQLSentence = $conection->prepare("SELECT * FROM Requests WHERE UserID=:id");
$SQLSentence->bindParam(':id',$userID);
$SQLSentence->execute();
$requestsDb = $SQLSentence->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="info">
            <div class="input-product">
                <div class="row">
                    <div class="col-2">
                                <form method="post" enctype="multipart/form-data">
                                    <div class = "form-group">
                                        <input type="text" hidden class="form-control" name="txtID" id="txtID"  value="<?= isset($requestDb) ? $requestDb['ProductID'] : "";?>" placeholder="ID" >
                                    </div>

                                    <div class = "form-group">
                                        <label for="txtNombre">Producto solicitado:</label>
                                        <input type="text" required class="form-control" name="txtNombre" id="txtNombre" value="<?= isset($requestDb) ? $requestDb['ProductName'] : "";?>" placeholder="Nombre del articulo">
                                    </div>

                                    <div class = "form-group">
                                        <label for="txtDescription">Descripcion de la solicitud:</label>
                                        <br>
                                        <textarea type="text" required class="form-control" name="txtDescription" id="txtDescription" placeholder="Descripcion del producto"
                                            style= "width: 329px; height: 67px;"> <?= isset($requestDb) ? $requestDb['ProductLongDesc'] : "";?> </textarea>
                                    </div>
                                    <br>

                                    <div class = "form-group">

                                        <label for="fileImages">Imagenes: </label>
                                        <br>
                                        <?php if(isset($requestDb)): ?>
                                            <?php if($requestDb['ProductImagesURL'] && $requestDb['ProductImagesURL'] != "no_image.jpg"): ?>
                                                <?php $images = explode(", ",$requestDb["ProductImagesURL"]); ?>
                                                <?php foreach($images as $image): ?>
                                                    <img src="../../images/<?= $image ?>" width="50" alt="">
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <div class="fileUpload btn btn-primary">
                                            <span>Upload</span>
                                            <input type="file" name="fileImages[]" id="fileImages[]" multiple="multiple">
                                        </div>
                                            <textarea readonly type="text" class="form-control" id="uploadFile" placeholder="Nombre de Archivos"
                                            style= "width: 329px; height: 67px;"></textarea>
                                            <p>Sube todos los archivos a la vez</p>
                                    </div>

                                    <div class="row" role="group" aria-label="">
                                        <div class="col-3">
                                            <button type="submit" name = "action" value = "CREATE" <?= $action == "SELECT"? "disabled":"" ?> class="btn">Agregar</button>
                                        </div>
                                        <div class="col-3">
                                            <button type="submit" name = "action" value = "UPDATE"  <?= $action != "SELECT"? "disabled":"" ?> class="btn">Modificar</button>
                                        </div>
                                        <div class="col-3">
                                            <button type="submit" name = "action" value = "CANCEL"  <?= $action != "SELECT"? "disabled":"" ?> class="btn">Cancelar</button>
                                        </div>
                                    </div>

                                </form>
                            <div class="card-footer text-muted">
                                Asegurate que este bien escrito todo,
                                despues no te estes arrepintiendo
                            </div>
                    </div>
                    <div class="col-2">
                        <table class="table table-border">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Tipo</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($requestsDb)): ?>
                                <?php foreach($requestsDb as $request): ?> 
                                    <tr>
                                        <td><?= $request["RequestID"]; ?></td>
                                        <td><?= $request["RequestName"]; ?></td>
                                        <td><?= $requestShortDesc = substr($request['RequestLongDesc'],0,250)."..."; ?></td>
                                        <td><?= $request["RequestCategoryID"]; ?></td>
                                        <td>
                                            <?php $images = explode(", ",$request["RequestImagesURL"]); ?>

                                            <?php foreach($images as $image): ?>
                                                <img src="../../images/<?= $image ?>" width="50" alt="">
                                            <?php endforeach; ?>
                                        </td>
                                        <td> 
                                            <form method="post">
                                                <input type="hidden" name="txtID" id="txtID" value="<?= $request["RequestID"]; ?>">
                                                <button type="submit" name="action" class="btn" value="SELECT">Seleccionar</button>
                                                <button type="submit" name="action" class="btn" value="DELETE">Borrar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <script>
            //Get the names of the files storaged in the input file and write it in the textarea
            var images = [];
            document.getElementById("fileImages[]").onchange = function () {
                for (let i = 0; i < this.files.length; i++){
                    images.push(this.files[i].name);
                }
                console.log(images);
                document.getElementById("uploadFile").value = images.join("\n");
                images = [];
            };
        </script>
<?php include("../../template/footer.php") ?>