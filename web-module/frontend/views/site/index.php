<?php

/* @var yii\web\View $this
 * @var common\models\Product[] $recent_added_products
 * @var common\models\Product[] $most_bought_products
 */

$this->title = 'Repara Tech';
?>


<style>


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
        color: #343a40;;
    }

    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    /* Footer */

    footer{
        background-color:#3D464D;
        text-align: center;
        padding: 50px 0;

    }
    .container-footer{
        max-width: 1400px;
        padding: 0 4%;
        margin: auto;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    .row-footer{
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .footer-col{
        width: 25%;
        padding: 0 15px;
        text-align: center;
    }

    .footer-col h4{
        font-size: 22px;
        color: #FFD333;
        margin-bottom: 20px;
        font-weight: 500;
        position: relative;
        text-transform: uppercase;
    }
    .footer-col ul{
        list-style: none;
        color: #FFD333;
    }
    .footer-col ul li{
        margin: 5px 0;
    }
    .footer-col ul li a{
        font-size: 16px;
        text-transform: capitalize;
        color: #FFD333;
        text-decoration: none;
        font-weight: 300;
        display: block;
        transition: all 0.3s ease;
    }
    .footer-col ul li a:hover{
        color: #FFD333;
        padding-left: 10px;
    }


    /* Carousel */

    .section-title-recentAddProducts{
        font-size: 30px;
        font-weight: 700;
        margin-left: 25px;
    }

    .section-title-bestSelling {
        font-size: 30px;
        font-weight: 700;
        margin: 25px;
    }


    #cCarousel {
        position: relative;
        margin: auto;
        background-color: #F5F5F5;
        background-size: 100%;
    }

    #cCarousel .arrow {
        position: absolute;
        top: 50%;
        display: flex;
        width: 45px;
        height: 45px;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        z-index: 1;
        font-size: 26px;
        color: white;
        background: #FFD333;
        cursor: pointer;
    }

    #cCarousel #prev {
        left: 80px;
    }

    #cCarousel #next {
        right: 80px;
    }

    #carousel-vp {
        width: 920px;
        height: 400px;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        margin: auto;
    }

    @media (max-width: 770px) {
        #carousel-vp {
            width: 510px;
        }
    }

    @media (max-width: 510px) {
        #carousel-vp {
            width: 250px;
        }
    }

    #cCarousel #cCarousel-inner {
        display: flex;
        position: absolute;
        transition: 0.3s ease-in-out;
        gap: 10px;
        left: 0px;
    }


    .cCarousel-item {
        width: 300px;
        height: 380px;
        border: 2px solid white;
        border-radius: 15px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .cCarousel-item img {
        width: 100%;
        object-fit: cover;
        min-height: 246px;
        color: white;
    }

    .cCarousel-item .infos {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        background: #3D464D;
        color: #FFD333;
    }

    .cCarousel-item .infos h3 {
        font-size: 20px;
        margin: 10px 0;
        color: #FFD333;
    }

    .cCarousel-item .infos p {
        font-size: 16px;
        margin: 10px 0;
    }

    .cCarousel-item .infos .btn-details a {
        background-color: #FFD333;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        margin-bottom: 50px;


</style>

<script>

    document.addEventListener("DOMContentLoaded", function() {
        const prev = document.querySelector("#prev");
        const next = document.querySelector("#next");

        let carouselVp = document.querySelector("#carousel-vp");
        let cCarouselInner = document.querySelector("#cCarousel-inner");
        let carouselInnerWidth = cCarouselInner.getBoundingClientRect().width;

        let leftValue = 0;

        // Variable used to set the carousel movement value (card's width + gap)
        const totalMovementSize =
            parseFloat(
                document.querySelector(".cCarousel-item").getBoundingClientRect().width,
                10
            ) +
            parseFloat(
                window.getComputedStyle(cCarouselInner).getPropertyValue("gap"),
                10
            );

        prev.addEventListener("click", () => {
            if (leftValue < 0) {
                leftValue += totalMovementSize;
                cCarouselInner.style.left = leftValue + "px";
            }
        });

        next.addEventListener("click", () => {
            const carouselVpWidth = carouselVp.getBoundingClientRect().width;
            if (carouselInnerWidth - Math.abs(leftValue) > carouselVpWidth) {
                leftValue -= totalMovementSize;
                cCarouselInner.style.left = leftValue + "px";
            }
        });

        const mediaQuery510 = window.matchMedia("(max-width: 510px)");
        const mediaQuery770 = window.matchMedia("(max-width: 770px)");

        mediaQuery510.addEventListener("change", mediaManagement);
        mediaQuery770.addEventListener("change", mediaManagement);

        let oldViewportWidth = window.innerWidth;

        function mediaManagement() {
            const newViewportWidth = window.innerWidth;

            if (leftValue <= -totalMovementSize && oldViewportWidth < newViewportWidth) {
                leftValue += totalMovementSize;
                cCarouselInner.style.left = leftValue + "px";
                oldViewportWidth = newViewportWidth;
            } else if (
                leftValue <= -totalMovementSize &&
                oldViewportWidth > newViewportWidth
            ) {
                leftValue -= totalMovementSize;
                cCarouselInner.style.left = leftValue + "px";
                oldViewportWidth = newViewportWidth;
            }
        }
    });
</script>


<section >
    <div class="section-title-recentAddProducts">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3">Most Recent Products</span>
        </h2>
    </div>
    <div id="cCarousel">
        <button class="arrow" id="prev" aria-label="Previous" role="button">
            <i class='fas fa-angle-left' style='font-size:36px;color:white'></i>
        </button>
        <button class="arrow" id="next" aria-label="Next" role="button">
            <i class='fas fa-angle-right' style='font-size:36px;color:white'></i>
        </button>

        <div id="carousel-vp">
            <div id="cCarousel-inner">
                <!-- Conteúdo dos itens do carrossel -->
                <?php foreach ($recent_added_products as $product) { ?>
                    <article class="cCarousel-item">
                        <img src="<?= htmlspecialchars($product->image) ?>" alt="<?= htmlspecialchars($product->name) ?>">
                        <div class="infos">
                            <div class="info-name">
                                <h3><?= htmlspecialchars($product->name) ?></h3>
                            </div>
                            <div class="info-price">
                                <p><?= number_format($product->price, 2) ?> €</p>
                            </div>
                            <div class="btn-details">
                                <a href="<?= \yii\helpers\Url::to(['product/details', 'id' => $product->id]) ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </article>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="section-title-bestSelling">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
            <span class="bg-secondary pr-3">Best-Selling Products</span>
        </h2>
    </div>
    <div id="cCarousel">
        <button class="arrow" id="prev" aria-label="Previous" role="button">
            <i class='fas fa-angle-left' style='font-size:36px;color:white'></i>
        </button>
        <button class="arrow" id="next" aria-label="Next" role="button">
            <i class='fas fa-angle-right' style='font-size:36px;color:white'></i>
        </button>

        <div id="carousel-vp">
            <div id="cCarousel-inner">
                <!-- Conteúdo dos itens do carrossel -->
                <?php foreach ($recent_added_products as $product) { ?>
                    <article class="cCarousel-item">
                        <img src="<?= htmlspecialchars($product->image) ?>" alt="<?= htmlspecialchars($product->name) ?>">
                        <div class="infos">
                            <div class="info-name">
                                <h3><?= htmlspecialchars($product->name) ?></h3>
                            </div>
                            <div class="info-price">
                                <p><?= number_format($product->price, 2) ?> €</p>
                            </div>
                            <div class="btn-details">
                                <a href="<?= \yii\helpers\Url::to(['product/details', 'id' => $product->id]) ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </article>
                <?php } ?>
            </div>
        </div>
    </div>
</section>


<!--
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Best-Selling Products</span>
    </h2>
    <div class="row px-xl-5">
        <//?php foreach ($most_bought_products as $product) { ?>
            <div class="col-12 col-md-6 col-lg-4 pb-1">

                <div class="card" style="width: 18rem;">
                    <img
                            src="<//?= $product->image !== '' ? $product->image : 'https://placehold.co/400' ?>"
                            class="card-img-top"
                            alt="<//?= $product->image !== '' ? $product->image : 'https://placehold.co/400' ?>"
                    >
                    <div class="card-body text-center">
                        <h5 class="card-title"><//?= htmlspecialchars($product->name) ?></h5>
                        <p class="card-text">Price: <//?= number_format($product->price, 2) ?> €</p>
                        <a
                                href="<//?= \yii\helpers\Url::to(['product/details', 'id' => $product->id]) ?><//?= $product->name ?>" class="btn btn-primary">View Details
                        </a>
                    </div>
                </div>
            </div>
        <//?php } ?>
    </div>
</div>

-->



<div class="container-fluid pt-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Some of the repairs we do</span></h2>
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<?=yii\helpers\Url::to(['site/audioIssue'])?>">
                <div class="cat-item d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fas fa-volume-mute' style='font-size:65px; color:#3D464D;'></i>
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
                        <i class='fas fa-mobile' style='font-size:65px;color:#3D464D;'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Broken Screen</strong></h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<//?=yii\helpers\Url::to(['site/connectivityIssue'])?>">
                <div class="cat-item img-zoom d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fas fa-share-alt-square' style='font-size:65px;color:#3D464D;'></i>
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
                        <i class='fas fa-wine-bottle' style='font-size:65px;color:#3D464D;'></i>
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
                        <i class='fas fa-power-off' style='font-size:65px;color:#3D464D;'></i>
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
                        <i class='fas fa-upload' style='font-size:65px;color:#3D464D;'></i>
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><strong>Data Recovery | Backup</strong></h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="<?=yii\helpers\Url::to(['site/cameraIssue'])?>">
                <div class="cat-item img-zoom d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
                        <i class='fas fa-camera' style='font-size:65px;color:#3D464D;'></i>
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
                        <i class='far fa-hdd' style='font-size:65px;color:#3D464D;'></i>
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
                        <i class='fas fa-battery-quarter' style='font-size:65px;color:#3D464D;'></i>
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
                        <i class='fa fa-wifi' style='font-size:65px;color:#3D464D;'></i>
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
                        <i class='fas fa-bug' style='font-size:65px;color:#3D464D;'></i>
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

<footer>
    <div class="container-footer">
        <div class="row-footer">

            <div class="footer-col">
                <h4><strong>About Company</strong></h4>
                <ul>
                    <li>Repair shop for multi-brand electronic devices and sale of accessories.</li>
                    <li>reparatech@store.com</li>
                    <li>Leiria, Portugal</li>
                </ul>
            </div>

            <div class="footer-col">
                <h4><strong>Our Website</strong></h4>
                <ul>
                    <li><a href="<? yii\helpers\Url::to([])?>"> List of Acessories</a></li>
                    <li><a href="<?=yii\helpers\Url::to(['site/allRepairCategories'])?>">Repair Categories</a></li>
                </ul>
            </div>
        </div>
    </div>



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

