<?php include("template/header.php"); ?>
<?php 
if(!(isset($_SESSION["User"]) && $_SESSION["User"] == "ok" && isset($_SESSION["UserID"]))){
    header("Location:admin/section/close.php");
}

include("admin/config/database.php");

$action = isset($_POST["action"]) ? $_POST["action"] : "";
if($action == "DELETE"){
    $SQLSentence = $conection->prepare("DELETE FROM Cart WHERE ProductID=:id");
    $SQLSentence->bindParam(':id',$_POST["txtID"]);
    $SQLSentence->execute();
    header("Location:cart.php");
}

$SQLSentence = $conection->prepare("
    SELECT Products.ProductID, Users.UserFirstName, Products.ProductName, Products.ProductPrice, Products.ProductImagesURL, Cart.Quantity
    FROM Cart
    INNER JOIN Products ON Cart.ProductID = Products.ProductID
    INNER JOIN Users ON Cart.UserID  = Users.UserID
    WHERE Users.UserID = :id;
");
$SQLSentence->bindParam(":id",$_SESSION["UserID"]);
$SQLSentence->execute();
$productsDb = $SQLSentence->fetchAll(PDO::FETCH_ASSOC);
?>
<!------------cart items details----------->
        <div class="info">
            <div class="small-container cart-page">
                <table>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php foreach($productsDb as $product): ?>
                    <tr>
                        <td>
                            <div class="cart-info">
                                <?php if(isset($product)): ?>
                                    <?php if($product['ProductImagesURL'] && $product['ProductImagesURL'] != "no_image.jpg"): ?>
                                        <?php $images = explode(", ",$product["ProductImagesURL"]); ?>
                                        <img src="images/<?= $images[0]?>">
                                    <?php endif; ?>
                                <?php endif; ?>
                                <div>
                                    <p><?=  $product["ProductName"]?></p>
                                    <small> Precio: $<?=$product["ProductPrice"]?> COP</small>
                                    <br>
                                    <form method="post">
                                        <input type="hidden" name="txtID" id="txtID" value="<?= $product["ProductID"]; ?>">
                                        <button type="submit" name="action" class="btn" value="DELETE">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number" value="<?=$product["Quantity"]?>">
                        </td>
                        <td>
                            $<?=$product["ProductPrice"]?> COP
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <!-- <tr>
                        <td>
                            <div class="cart-info">
                                <img src="images/Wrench.jpg">
                                <div>
                                    <p>Llave inglesa</p>
                                    <small> Precio: $40.000 COP</small>
                                    <br>
                                    <a href="">Remove</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number" value="1">
                        </td>
                        <td>
                            $40.0000 COP
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="cart-info">
                                <img src="images/screwdriver_2.jpg">
                                <div>
                                    <p>Destornillador de pala</p>
                                    <small> Precio: $10.000 COP</small>
                                    <br>
                                    <a href="">Remove</a>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="number" value="1">
                        </td>
                        <td>
                            $10.0000 COP
                        </td>
                    </tr> -->
                </table>
                <div class="total-price">
                    <table>
                        <tr>
                            <td>
                                Subtotal
                            </td>
                            <td>
                                $0 COP
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Tax 0%
                            </td>
                            <td>
                                $0 COP
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Total
                            </td>
                            <td>
                                $0 COP
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
        
<?php include("template/footer.php"); ?>