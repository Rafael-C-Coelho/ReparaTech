<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\Sale $sale */

?>
<div>
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>The sale #<?= $sale->id ?> has been sent:</p>

    <p><?= Html::a(Html::encode(Yii::$app->params["frontend_url"] . "order/index"), Yii::$app->params["frontend_url"] . "order/index") ?></p>

    <p>Best regards,</p>
    <p>The Repair Team</p>
</div>
