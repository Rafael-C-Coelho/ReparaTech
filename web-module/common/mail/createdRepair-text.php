<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

use yii\helpers\Html;

?>
Hello <?= $user->username ?>,

Follow the link below to check your repair's status:

<?= Html::a(Html::encode(Yii::$app->params["frontend_url"] . "repair/index"), Yii::$app->params["frontend_url"] . "repair/index") ?>

Best regards,
The Repair Team