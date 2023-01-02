<?php include("template/header.php"); ?>
<?php 
include("admin/config/database.php"); 
$SQLSentence = $conection->prepare("SELECT * FROM Products");
$SQLSentence->execute();
$productsDb = $SQLSentence->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="info">
            <div class="small-container">
                <div class="row row-2">
                    <h2>Todos los productos</h2>
                    <select>
                        <option value="">Por Defecto</option>
                        <option value="">Organizar por precio</option>
                        <option value="">Organizar por popularidad</option>
                        <option value="">Organizar por reseñas</option>
                        <option value="">Organizar por ventas</option>
                    </select>
                </div>
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
                            <p>$<?=$product["ProductPrice"]?> Cop</p>
                        </div>
                    <?php endforeach; ?>
                    <!-- <div class="col-4">
                        <img src="images/saw.jpg">
                        <h4>Sierra de mano</h4>
                        <div class="love">
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart-crack"></i>
                            <i class="fa-regular fa-heart"></i>
                        </div>
                        <p>$30.000 Cop</p>
                    </div>
                    <div class="col-4">
                        <img src="images/screwdriver_2.jpg">
                        <h4>Destornillador de pala</h4>
                        <div class="love">
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart-crack"></i>
                            <i class="fa-regular fa-heart"></i>
                            <i class="fa-regular fa-heart"></i>
                            <i class="fa-regular fa-heart"></i>
                        </div>
                        <p>$10.000 Cop</p>
                    </div>
                    <div class="col-4">
                        <img src="images/tweezers_2.jpg">
                        <h4>Pinzas</h4>
                        <div class="love">
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart-crack"></i>
                        </div>
                        <p>$25.000 Cop</p>
                    </div>
                    <div class="col-4">
                        <img src="images/Wrench.jpg">
                        <h4>Llave inglesa</h4>
                        <div class="love">
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <p>$40.000 Cop</p>
                    </div>
                    <div class="col-4">
                        <img src="images/screw.jpg">
                        <h4>Tornillos</h4>
                        <div class="love">
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <p>$5.000 Cop</p>
                    </div>
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
                    <div class="col-4">
                        <img src="images/bricks.jpg">
                        <h4>Ladrillos 20</h4>
                        <div class="love">
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <p>$40.000 Cop</p>
                    </div>
                    <div class="col-4">
                        <img src="images/tacks.jpg">
                        <h4>Tachuelas</h4>
                        <div class="love">
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <p>$3.000 Cop</p>
                    </div> -->
                </div>
                <!-- <div class="page-btn">
                    <span>1</span>
                    <span>2</span>
                    <span>3</span>
                    <span>4</span>
                    <span>&#8594;</span>
                </div> -->
            </div>
        </div>
<?php include("template/footer.php"); ?>