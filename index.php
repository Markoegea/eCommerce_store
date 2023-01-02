<?php include("template/header.php"); ?>
<?php include("admin/config/database.php");
$SQLSentence = $conection->prepare("SELECT * FROM Products");
$SQLSentence->execute();
$productsDb = $SQLSentence->fetchAll(PDO::FETCH_ASSOC);
$SQLSentence = $conection->prepare("SELECT * FROM Requests");
$SQLSentence->execute();
$requestsDb = $SQLSentence->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        <h1>Encuentra lo que necesitas <br>Al alcance de un click!</h1>
                        <p>Hoy en día toda persona necesita comprar algo en la ferretería, <br>
                        por eso es atractivo para él o para ella que este sea practica y sencilla</p>
                        <a href="products.php" class="btn">Entrar a Vitrinear <b>&#9755;</b></a>
                    </div>
                    <div class="col-2">
                        <img src="images/all_tools.jpg">
                    </div>
                </div>
            </div>
        </div>

        <div class="info">

            <!--------------------featured products------------------------>
            <div class="small-container">
                <h2 class="title">Productos Destacados</h2>
                <div class="row">
                    <?php foreach($productsDb as $product): ?>
                        <div class="col-4">
                            <a href="product-details.php?id=<?= $product["ProductID"]; ?>">
                                <?php $images = explode(", ",$product["ProductImagesURL"]); ?>
                                <img src="images/<?= $images[0] ?>" alt="">
                            </a>
                            <h4><?=$product['ProductName']?></h4>
                            <div class="love">
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart-crack"></i>
                                <i class="fa-regular fa-heart"></i>
                            </div>
                            <p></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <!--------------------featured requests------------------------>
                <h2 class="title">Ultimas peticiones</h2>
                <div class="row">
                    <?php foreach($requestsDb as $request): ?>
                        <div class="col-4">
                            <a href="request-details.php?id=<?= $request["RequestID"]; ?>">
                                <?php $images = explode(", ",$request["RequestImagesURL"]); ?>
                                <img src="images/<?= $images[0] ?>" alt="">
                            </a>
                            <h4><?=$request['RequestName']?></h4>
                            <div class="love">
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart-crack"></i>
                                <i class="fa-regular fa-heart"></i>
                            </div>
                            <p></p>
                        </div>
                    <?php endforeach; ?>
                </div> 
                
            </div>
<!--------------------testimonial------------------------>
            <div class="testimonial">
                <div class="small-container">
                    <div class="row">
                        <div class="col-3">
                            <i class="fa fa-quote-left"></i>
                            <p>Una muy buena pagina de compra y venta</p>
                            <div class="rating">
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                            </div>
                            <img src="images/profile.jpg">
                            <h3>Gustavo Duarte</h3>
                        </div>
                        <div class="col-3">
                            <i class="fa fa-quote-left"></i>
                            <p>Me gusto!!!</p>
                            <div class="rating">
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                            </div>
                            <img src="images/profile.jpg">
                            <h3>Irina Sanchez</h3>
                        </div>
                        <div class="col-3">
                            <i class="fa fa-quote-left"></i>
                            <p>Bueno, bonito y barato</p>
                            <div class="rating">
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                                <i class="fa-solid fa-heart"></i>
                            </div>
                            <img src="images/profile.jpg">
                            <h3>Piedad Gomez</h3>
                        </div>
                    </div>
                </div>
            </div>
<!--------------------brands------------------------>
            <div class="brands">
                <div class="small-container">
                    <div class="row">
                        <div class="col-5">
                            <img src="https://cdn.pixabay.com/photo/2017/08/05/11/16/logo-2582748_960_720.png">
                        </div>
                        <div class="col-5">
                            <img src="images/logo_1.png">
                        </div>
                        <div class="col-5">
                            <img src="images/logo_2.png">
                        </div>
                        <div class="col-5">
                            <img src="images/logo_3.png">
                        </div>
                        <div class="col-5">
                            <img src="images/logo_4.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php include("template/footer.php"); ?>