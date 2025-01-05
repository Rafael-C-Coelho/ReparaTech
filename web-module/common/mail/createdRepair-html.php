<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div>
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to check the repair status:</p>

    <p><?= Html::a(Html::encode(Yii::$app->params["frontend_url"] . "repair/index"), Yii::$app->params["frontend_url"] . "repair/index") ?></p>

    <p>Best regards,</p>
    <p>The Repair Team</p>
</div>
