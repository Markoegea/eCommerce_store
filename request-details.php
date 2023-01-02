<?php include("template/header.php"); ?>
    <?php 
        include("admin/config/database.php");
        $SQLSentence = $conection->prepare("SELECT * FROM Requests WHERE RequestID=:id");
        $SQLSentence->bindParam(':id',$_GET["id"]);
        $SQLSentence->execute();
        $requestDb = $SQLSentence->fetch(PDO::FETCH_LAZY);
    ?>
        <div class="info">
            <!---Single product data-->
            <div class="small-container single-product">
                <div class="row">
                    <div class="col-2">
                        <?php $images = explode(", ",$requestDb["RequestImagesURL"]); ?>

                        <img src="images/<?= $images[0] ?>" width="100%" id="product-img">

                        <div class="small-img-row">

                        <?php for($i = 0;  $i < count($images); $i++): ?>
                            <div class="small-img-col">
                                <img src="images/<?= $images[$i] ?>" width="100%" class="small-img">
                            </div>
                        <?php endfor; ?>
                        </div>
                    </div>
                    <div class="col-2">
                        <p></p>
                        <h1><?= $requestDb["RequestName"] ?></h1>
                        <a href="user-details.php?id=<?=$requestDb["UserID"]?>" class="btn">Contacta al solicitante</a>
                        <h3>Detalles de la solicitud <i class="fa-solid fa-outdent"></i></h3>
                        <br>
                        <p>
                        <?= $requestDb["RequestLongDesc"] ?>  
                        </p>
                    </div>
                </div>
            </div>
<!---------------- title --------------->

            <div class="small-container">
                <div class="row row-2">
                    <h2>Solicitudes relacionados</h2>
                    <p>Ver mas</p>
                </div>
            </div>

<!---------------- products --------------->
            <!-- <div class="small-container">
                <div class="row">
                    <div class="col-4">
                        <img src="images/hinge.png">
                        <h4>Bisagra</h4>
                        <div class="love">
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart-crack"></i>
                            <i class="fa-regular fa-heart"></i>
                            <i class="fa-regular fa-heart"></i>
                            <i class="fa-regular fa-heart"></i>
                        </div>
                        <p>$5.600 Cop</p>
                    </div>
                    <div class="col-4">
                        <img src="images/hinge_2.png">
                        <h4>Bisagra</h4>
                        <div class="love">
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart-crack"></i>
                        </div>
                        <p>$4.000 Cop</p>
                    </div>
                    <div class="col-4">
                        <img src="images/glass.jpg">
                        <h4>Vidria 20x20cm</h4>
                        <div class="love">
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <p>$60.000 Cop</p>
                    </div>
                    <div class="col-4">
                        <img src="images/paint.jpg">
                        <h4>Pintura</h4>
                        <div class="love">
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <p>$50.000 Cop</p>
                    </div>
                </div>
            </div> -->
        </div>
    <script>
        var product_img = document.getElementById("product-img");
        var small_imgs = document.getElementsByClassName("small-img");

        <?php for($i = 0;  $i < count($images); $i++): ?>
            small_imgs[<?=$i?>].onclick = function(){
                product_img.src = small_imgs[<?=$i?>].src;
            }
        <?php endfor; ?>
    </script>

    <?php include("template/footer.php"); ?>