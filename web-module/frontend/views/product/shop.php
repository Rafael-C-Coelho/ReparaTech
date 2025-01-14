<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

$this->title = Yii::t('app', 'Shop');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Shop'), 'url' => ['index']];
?>
<style>
    /* Flexbox on the container to align cards */
    .row.pb-3 {
        display: flex;
        flex-wrap: wrap;
    }

    .disabled {
        display: none;
    }

    /* Ensure each card takes equal height in its row */
    .product-item {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-img {
        flex-grow: 1;
        background-color: #f0f0f0; /* Background for cards without images */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    /* Ensure images scale without distortion */
    .product-img img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    /* Ensure the footer aligns at the bottom */
    .card-body, .card-footer {
        flex-shrink: 0;
    }
</style>
<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Price Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by category</span></h5>
            <div class="bg-light p-4 d-flex justify-content-center align-items-center">
                <form method="get">
                    <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-2">
                        <input type="radio" name="category_id" class="custom-control-input" value="" id="category-all" <?= empty(Yii::$app->request->get('category_id')) ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="category-all">All categories</label>
                    </div>
                    <?php foreach ($categories as $category) { ?>
                        <div class="custom-control custom-radio d-flex align-items-center justify-content-between mb-2">
                            <input type="radio" name="category_id" class="custom-control-input" value="<?= $category->id ?>" id="category-<?= $category->id ?>" <?= Yii::$app->request->get('category_id') == $category->id ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="category-<?= $category->id ?>"><?= Html::encode($category->name) ?></label>
                        </div>
                    <?php } ?>
                    <button type="submit" class="btn btn-primary btn-block mt-3">Filter</button>
                </form>
            </div>
            <!-- Price End -->
        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <?php foreach ($products as $product) { ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1 d-flex">
                        <a href="<?= \yii\helpers\Url::to(['product/details', 'id' => $product->id]) ?>" class="w-100">
                            <div class="card product-item bg-light mb-4 h-75">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid" src="<?= $product->image ? $product->image : 'https://placehold.co/400' ?>" alt="" onerror="this.src='https://placehold.co/600x500?text=No+image'">
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title text-truncate"><?= Html::encode($product->name) ?></h5>
                                    <div class="d-flex justify-content-center align-items-center mt-2">
                                        <h5><?= Html::encode($product->price) ?> €</h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php } ?>
                <div class="col-12">
                    <nav>
                        <?= LinkPager::widget([
                            'pagination' => $pagination,
                            'options' => ['class' => 'pagination justify-content-center'],
                            'linkOptions' => ['class' => 'page-link'],
                            'disabledListItemSubTagOptions' => ['class' => 'page-item disabled'],
                            'activePageCssClass' => 'page-item active',
                        ]) ?>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->
