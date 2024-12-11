<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

use yii\helpers\Html;

?>
Hello <?= $user->username ?>,

Follow the link below to verify your email:

<?= Html::a(Html::encode(Yii::$app->params["frontendUrl"] . "site/repairs"), Yii::$app->params["frontendUrl"] . "site/repairs") ?>

Best regards,
The Repair Team