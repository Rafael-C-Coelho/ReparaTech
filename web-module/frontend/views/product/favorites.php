<?php

use yii\helpers\Html;

$this->title = 'Favorites';

?>

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                <tr>
                    <th>Product name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody class="align-middle">
                <?php if (empty($favorites)) { ?>
                    <tr>
                        <td colspan="4" class="align-middle">No favorites yet</td>
                    </tr>
                <?php } ?>
                <?php foreach ($favorites as $product) { ?>
                    <tr>
                        <td class="align-middle"><a href="<?= \yii\helpers\Url::to(['product/details', 'id' => $product->id]) ?>"><?= $product->name ?></a></td>
                        <td class="align-middle"><?= number_format($product->price, 2)?> €</td>
                        <td class="align-middle"><img src="<?= $product->image ?>" alt="" style="width: 50px;"></td>
                        <td class="align-middle">
                            <form method="post" action="<?= \yii\helpers\Url::to(['product/toggle-favorites']) ?>">
                                <input type="hidden" name="returnUrl" value="<?= Yii::$app->request->url ?>" />
                                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                                <input type="hidden" name="productId" value="<?= $product->id ?>" />
                                <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-times"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
