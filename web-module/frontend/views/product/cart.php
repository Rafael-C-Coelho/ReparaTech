<?php

use yii\helpers\Html;


$this->title = 'Cart';
?>

<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                <tr>
                    <th>Product name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody class="align-middle">
                <?php foreach ($list as $item) { ?>
                    <?php
                        $product = $item["product"];
                        $quantity = $item["quantity"];
                    ?>
                    <tr>
                        <td class="align-middle"><?= $product->name ?></td>
                        <td class="align-middle"><?= Yii::$app->formatter->asCurrency(number_format($product->price, 2), "EUR") ?></td>
                        <td class="align-middle">
                            <div data-product="<?= $product->id ?>" class="quantity-div input-group quantity mx-auto" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="quantity-input form-control form-control-sm bg-secondary border-0 text-center"
                                       value="<?= $quantity ?>" max="<?= $product->stock ?>">
                                <div class="input-group-btn">
                                    <button onclick="manageCart('<?= $product->id ?>', 0)" class="btn btn-sm btn-primary btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                        </td>
                        <td class="align-middle"><img src="<?= $product->image ?>" alt="" style="width: 50px;"></td>
                        <td class="align-middle">
                            <button class="btn btn-sm btn-danger" onclick="manageCart('<?= $product->id ?>', 0)"><i class="fa fa-times"></i></button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span
                        class="bg-secondary pr-3">Summary</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <?php
                        $subtotal = 0;
                        foreach ($list as $item) {
                            $product = $item["product"];
                            $quantity = $item["quantity"];
                            $subtotal += $product->price * $quantity;
                        }
                        ?>
                        <h6><?= Yii::$app->formatter->asCurrency($subtotal, "EUR") ?></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium"><?= Yii::$app->formatter->asCurrency(Yii::$app->params["defaultShipping"], "EUR") ?></h6>
                    </div>
                </div>
                <?php if (isset($list) && sizeof($list)) { ?>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5><?= Yii::$app->formatter->asCurrency($subtotal + Yii::$app->params["defaultShipping"], "EUR") ?></h5>
                    </div>
                    <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<script>
    function manageCart(productId, quantity) {
        event.preventDefault();
        $.ajax({
            url: '<?= \yii\helpers\Url::to(["product/manage-cart"])?>',
            type: 'POST',
            data: {
                productId: productId,
                quantity: quantity
            },
            success: function(response) {
                console.log("Cart updated successfully:", response);
            },
            error: function(xhr, status, error) {
                console.error("Error updating cart:", error);
                // Handle error response
            },
        });
        window.location.reload();
    }

    $(document).ready(function() {
        $(document).on('click', '.quantity-div', function() {
            // Get the productId from the data-product attribute
            let productId = $(this).data('product');
            // Get the quantity from the inner .quantity-input field
            let quantity = $(this).find('.quantity-input').val();
            console.log("Product ID:", productId, "Quantity:", quantity);
            // Send the AJAX request
            manageCart(productId, quantity);
        });
    });
</script>