<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var bool $isFavorite */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shop'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" src="<?= $model->image ? (str_contains($model->image, "http") ? $model->image : '/assets/products/' . basename($model->image)) : 'https://placehold.co/400' ?>"
                             alt="Image">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30 d-flex flex-column justify-content-center align-items-center">
                <h3><?= $model->name ?></h3>
                <h3 class="font-weight-semi-bold mb-4"><?= number_format($model->price, 2) ?> €</h3>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="d-flex">
                        <form method="post" class="d-flex"
                              action="<?= \yii\helpers\Url::to(['product/manage-cart']) ?>">
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                   value="<?= Yii::$app->request->csrfToken; ?>"/>
                            <div class="input-group quantity mr-3" style="width: 130px;">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-minus" onclick="updateQuantity(-1)">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input name="quantity" type="text"
                                       class="form-control bg-secondary border-0 text-center" value="1" max="<?= $model->stock ?>" min="0" id="quantity-input">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-plus" onclick="updateQuantity(1)">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <button class="btn btn-primary px-3 mr-3" type="submit"><i
                                        class="fa fa-shopping-cart mr-1"></i> Add To
                                Cart
                            </button>
                            <input type="hidden" name="productId" value="<?= $model->id ?>">
                        </form>
                        <form method="post" action="<?= \yii\helpers\Url::to(['product/toggle-favorites']) ?>">
                            <input type="hidden" name="returnUrl" value="<?= Yii::$app->request->url ?>" />
                            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>"
                                   value="<?= Yii::$app->request->csrfToken; ?>"/>
                            <input type="hidden" name="productId" value="<?= $model->id ?>">
                            <button class="btn btn-primary px-3"><i
                                        class="fa fa-heart<?= $isFavorite ? '-broken' : '' ?>"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->

<script>
    function updateQuantity(change) {
        const input = document.getElementById('quantity-input');
        let currentValue = parseInt(input.value);
        const max = parseInt(input.getAttribute('max'));
        const min = parseInt(input.getAttribute('min'));

        currentValue += change;
        if (currentValue > max) {
            currentValue = max;
        } else if (currentValue < min) {
            currentValue = min;
        }

        input.value = currentValue;
    }
</script>

<!-- Products Start
<div class="container-fluid py-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span>
    </h2>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                <div class="product-item bg-light">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="./web/img/product-1.jpg" alt="">
                        <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="">Product Name Goes Here</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>$123.00</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
Products End -->
