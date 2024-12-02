<?php

/* @var yii\web\View $this
 * @var common\models\Product[] $recent_added_products
 * @var common\models\Product[] $most_bought_products
 */

$this->title = 'Repara Tech';
?>

<style>

    .row.pb-3 {
        display: flex;
        flex-wrap: wrap;
    }


    .product-item {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-img {
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .section-title {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 30px;
    }


    .product-img img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }


    .card-body, .card-footer {
        flex-shrink: 0;
    }

    .cat-item {
        border-radius: 10px;
        display: flex;
        height: 100%;
        max-height: 100px;
        box-sizing: border-box;
    }

    .viewAll{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        text-align: center;
        width: 100%;
        background: #FFD333;
        border-radius: 10px;
    }

    .viewAll h6 {
        font-size: 30px;
        color: grey;
    }


</style>

    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Recently Added Products</span></h2>
        <div class="row px-xl-5">
            <?php foreach ($recent_added_products as $product) { ?>
                <div class="col pb-1">
                    <div class="product-item bg-light mb-4 h-75">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="<?= $product->image !== '' ? $product->image : 'https://placehold.co/400' ?>" alt="Image">
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="<?= \yii\helpers\Url::to(['product/details', 'id' => $product->id]) ?>"><?= $product->name ?></a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5><?= $product->price ?> €</h5>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- Products End -->

    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Best-Selling Products</span></h2>
        <div class="row px-xl-5">
            <?php foreach ($most_bought_products as $product) { ?>
                <div class="col pb-1">
                    <div class="product-item bg-light mb-4 h-75">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="<?= $product->image !== '' ? $product->image : 'https://placehold.co/400' ?>" alt="Image">
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="<?= \yii\helpers\Url::to(['product/details', 'id' => $product->id]) ?>"><?= $product->name ?></a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5><?= $product->price ?> €</h5>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>


<div class="container-fluid pt-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Some of the repairs we do</span></h2>
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<?=yii\helpers\Url::to(['site/audioIssue'])?>">
                <div class="cat-item d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fas fa-volume-mute' style='font-size:65px; color:grey;'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Audio Issues</strong></h6>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<?=yii\helpers\Url::to(['site/brokenScreen'])?>">
                <div class="cat-item d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fas fa-mobile' style='font-size:65px;color:grey'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Broken Screen</strong></h6>
                    </div>
                </div>
            </a>
        </div>
        <!--
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<//?=yii\helpers\Url::to(['site/connectivityIssue'])?>">
                <div class="cat-item img-zoom d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fas fa-share-alt-square' style='font-size:65px;color:grey'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Connectivity Issues</strong></h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href=" <//?=yii\helpers\Url::to(['site/liquidDamage'])?>">
                <div class="cat-item img-zoom d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fas fa-wine-bottle' style='font-size:65px;color:grey'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Liquid Damage</strong></h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<//?=yii\helpers\Url::to(['site/damageButton'])?>">
                <div class="cat-item img-zoom d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fas fa-power-off' style='font-size:65px;color:grey'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Damaged Buttons</strong></h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 pb-1" >
            <a class="text-decoration-none" href="<//?=yii\helpers\Url::to(['site/dataRecovery'])?>">
                <div class="cat-item img-zoom d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fas fa-upload' style='font-size:65px;color:grey'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Data Recovery | Backup</strong></h6>
                    </div>
                </div>
            </a>
        </div>
        -->
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<?=yii\helpers\Url::to(['site/cameraIssue'])?>">
                <div class="cat-item img-zoom d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fas fa-camera' style='font-size:65px;color:grey'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Camera Issues</strong></h6>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<?=yii\helpers\Url::to(['site/storageIssue'])?>">
                <div class="cat-item img-zoom d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='far fa-hdd' style='font-size:65px;color:grey'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Storage Issues</strong></h6>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<?=yii\helpers\Url::to(['site/batteryIssue'])?>">
                <div class="cat-item img-zoom d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fas fa-battery-quarter' style='font-size:65px;color:grey'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Battery Issues</strong></h6>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<?=yii\helpers\Url::to(['site/networkIssue'])?>">
                <div class="cat-item img-zoom d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fa fa-wifi' style='font-size:65px;color:grey'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Network Issues</strong></h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<?=yii\helpers\Url::to(['site/softwareIssue'])?>">
                <div class="cat-item img-zoom d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fas fa-bug' style='font-size:65px;color:grey'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Software Issues</strong></h6>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<?=yii\helpers\Url::to(['site/allRepairCategories'])?>">
                <div class="cat-item img-zoom d-flex align-items-center mb-4">
                    <div class="viewAll">
                        <h6 class=""><strong>VIEW ALL</strong></h6>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- Categories End -->

<!-- Footer Start -->
<div class="container-fluid bg-dark text-secondary mt-5 pt-5">
    <div class="containerAll">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-light text-uppercase mb-4">ReparaTech</h5>
                <p class="mb-4">Repair shop for multi-brand electronic devices and sale of accessories.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Leiria, Portugal</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>reparatech@store.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+351 992 345 678</p>
            </div>

            <div class="col-lg-2 col-md-6 mb-5">
                <h5 class="text-light text-uppercase mb-4">Quick Shop</h5>
                <div class="d-flex flex-column">
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                    <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                </div>
            </div>

            <!-- Minha Conta -->
            <div class="col-lg-2 col-md-6 mb-5">
                <h5 class="text-light text-uppercase mb-4">My Account</h5>
                <div class="d-flex flex-column">
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                    <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                </div>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 text-center text-md-left">
                <p class="mb-md-0 text-secondary">
                    &copy; <a class="text-primary" href="#">ReparaTech</a>. All Rights Reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-right">
                <p class="mb-0 text-secondary">Designed by <a class="text-primary" href="https://htmlcodex.com">HTML Codex</a></p>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/lib/easing/easing.min.js"></script>

<script src="<?= Yii::getAlias('@web') ?>/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Contact Javascript File -->
<script src="<?= Yii::getAlias('@web') ?>/mail/jqBootstrapValidation.min.js"></script>
<script src="<?= Yii::getAlias('@web') ?>/mail/contact.js"></script>

<!-- Template Javascript -->
<script src="<?= Yii::getAlias('@web') ?>/js/main.js"></script>

