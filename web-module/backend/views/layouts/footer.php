<?php

use yii\bootstrap4\Html;

?>
<footer class="main-footer">
    <strong>Copyright &copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Creators:</b> Diogo Gouveia, Rafael Coelho e Rafael Reis
    </div>
</footer>