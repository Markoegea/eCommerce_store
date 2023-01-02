<?php include("../../template/header.php") ?>

<?php 
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
            INSERT INTO Products(UserID, ProductName, ProductPrice, ProductLongDesc, ProductCategoryID, ProductImagesURL) 
            VALUES (:id ,:name, 0, :description, 1, :images);
        ");
        $SQLSentence->bindParam(":id",$userID);
        $SQLSentence->bindParam(":name",$txtNombre);
        $SQLSentence->bindParam(":description",$txtDescription);
        $imageStorage = array_map("assingName",$_FILES["fileImages"]["name"],$_FILES["fileImages"]["tmp_name"]);
        $stringImages = implode(", ",$imageStorage);
        $SQLSentence->bindParam(":images",$stringImages);
        $SQLSentence->execute();
        header("Location:products.php");
        break;

    case "UPDATE";
        $SQLSentence = $conection->prepare("UPDATE Products SET ProductName=:name, ProductLongDesc=:description WHERE ProductID=:id");
        $SQLSentence->bindParam(':id',$txtID);
        $SQLSentence->bindParam(':name',$txtNombre);
        $SQLSentence->bindParam(':description',$txtDescription);
        $SQLSentence->execute();

        if(!empty($images[0])){
            $SQLSentence = $conection->prepare("SELECT ProductImagesURL FROM Products WHERE ProductID=:id");
            $SQLSentence->bindParam(':id',$txtID);
            $SQLSentence->execute();
            $productDb = $SQLSentence->fetch(PDO::FETCH_LAZY);
            if(isset($productDb["ProductImagesURL"]) && ($productDb["ProductImagesURL"] != ["no_image.jpg"])){
                $imagesList = explode(", ",$productDb["ProductImagesURL"]);
                foreach ($imagesList as $image){
                    if(file_exists("../../images/".$image)){
                        unlink("../../images/".$image);
                    }
                }
            }

            $SQLSentence = $conection->prepare("UPDATE Products SET ProductImagesURL=:images WHERE ProductID=:id");
            $SQLSentence->bindParam(':id',$txtID);
            $imageStorage = array_map("assingName",$_FILES["fileImages"]["name"],$_FILES["fileImages"]["tmp_name"]);
            $stringImages = implode(", ",$imageStorage);
            $SQLSentence->bindParam(':images',$stringImages);
            $SQLSentence->execute();
        }
        header("Location:products.php");
        break;

    case "DELETE";
        $SQLSentence = $conection->prepare("SELECT ProductImagesURL FROM Products WHERE ProductID=:id");
        $SQLSentence->bindParam(':id',$txtID);
        $SQLSentence->execute();
        $productDb = $SQLSentence->fetch(PDO::FETCH_LAZY);
        if(isset($productDb["ProductImagesURL"]) && ($productDb["ProductImagesURL"] != ["no_image.jpg"])){
            $imagesList = explode(", ",$productDb["ProductImagesURL"]);
            foreach ($imagesList as $image){
                if(file_exists("../../images/".$image)){
                    unlink("../../images/".$image);
                }
            }
        }

        $SQLSentence = $conection->prepare("DELETE FROM Products WHERE ProductID=:id");
        $SQLSentence->bindParam(':id',$txtID);
        $SQLSentence->execute();
        header("Location:products.php");
        break;

    case "SELECT";
        $SQLSentence = $conection->prepare("SELECT * FROM Products WHERE ProductID=:id");
        $SQLSentence->bindParam(':id',$txtID);
        $SQLSentence->execute();
        $productDb = $SQLSentence->fetch(PDO::FETCH_LAZY);
        break;

    case "CANCEL";
        header("Location:products.php");
        break;
}

$SQLSentence = $conection->prepare("SELECT * FROM Products WHERE UserID=:id");
$SQLSentence->bindParam(':id',$userID);
$SQLSentence->execute();
$productsDb = $SQLSentence->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="info">
            <div class="input-product">
                <div class="row">
                    <div class="col-2">
                                <form method="post" enctype="multipart/form-data">
                                    <div class = "form-group">
                                        <label for="txtID">ID:</label>
                                        <input type="text" required readonly class="form-control" name="txtID" id="txtID"  value="<?= isset($productDb) ? $productDb['ProductID'] : "";?>" placeholder="ID" >
                                    </div>

                                    <div class = "form-group">
                                        <label for="txtNombre">Nombre:</label>
                                        <input type="text" required class="form-control" name="txtNombre" id="txtNombre" value="<?= isset($productDb) ? $productDb['ProductName'] : "";?>" placeholder="Nombre del articulo">
                                    </div>

                                    <div class = "form-group">
                                        <label for="txtDescription">Descripcion del producto:</label>
                                        <br>
                                        <textarea type="text" required class="form-control" name="txtDescription" id="txtDescription" placeholder="Descripcion del producto"
                                            style= "width: 329px; height: 67px;"> <?= isset($productDb) ? $productDb['ProductLongDesc'] : "";?> </textarea>
                                    </div>
                                    <br>

                                    <div class = "form-group">

                                        <label for="fileImages">Imagenes: </label>
                                        <br>
                                        <?php if(isset($productDb)): ?>
                                            <?php if($productDb['ProductImagesURL'] && $productDb['ProductImagesURL'] != "no_image.jpg"): ?>
                                                <?php $images = explode(", ",$productDb["ProductImagesURL"]); ?>
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
                                            <button type="submit" name = "action" value = "CREATE" <?= $action == "SELECT"? "disabled":"" ?> class="btn btn-success">Agregar</button>
                                        </div>
                                        <div class="col-3">
                                            <button type="submit" name = "action" value = "UPDATE"  <?= $action != "SELECT"? "disabled":"" ?> class="btn btn-warning">Modificar</button>
                                        </div>
                                        <div class="col-3">
                                            <button type="submit" name = "action" value = "CANCEL"  <?= $action != "SELECT"? "disabled":"" ?> class="btn btn-info">Cancelar</button>
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
                                    <th>Precio</th>
                                    <th>Tipo</th>
                                    <th>Stock</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($productsDb)): ?>
                                <?php foreach($productsDb as $product): ?> 
                                    <tr>
                                        <td><?= $product["ProductID"]; ?></td>
                                        <td><?= $product["ProductName"]; ?></td>
                                        <td><?= $ProductShortDesc = substr($product['ProductLongDesc'],0,250)."..."; ?></td>
                                        <td><?= $product["ProductPrice"]; ?></td>
                                        <td><?= $product["ProductCategoryID"]; ?></td>
                                        <td><?= $product["ProductStock"]; ?></td>
                                        <td>
                                            <?php $images = explode(", ",$product["ProductImagesURL"]); ?>

                                            <?php foreach($images as $image): ?>
                                                <img src="../../images/<?= $image ?>" width="50" alt="">
                                            <?php endforeach; ?>
                                        </td>
                                        <td> 
                                            <form method="post">
                                                <input type="hidden" name="txtID" id="txtID" value="<?= $product["ProductID"]; ?>">
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