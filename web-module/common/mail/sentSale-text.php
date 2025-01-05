<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\Sale $sale */

use yii\helpers\Html;

?>
Hello <?= $user->username ?>,

The sale #<?= $sale->id ?> has been sent:

<?= Html::a(Html::encode(Yii::$app->params["frontend_url"] . "repair/index"), Yii::$app->params["frontend_url"] . "repair/index") ?>

Best regards,
The Repair Team