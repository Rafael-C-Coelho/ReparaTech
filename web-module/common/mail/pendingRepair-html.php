<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to accept or deny the repair budget:</p>

    <p><?= Html::a(Html::encode(Yii::$app->params["frontendUrl"] . "site/repairs/"), Yii::$app->params["frontendUrl"] . "site/repairs") ?></p>

    <p>Best regards,</p>
    <p>The Repair Team</p>
</div>
