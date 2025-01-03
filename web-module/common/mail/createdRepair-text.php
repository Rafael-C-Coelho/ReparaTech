<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */

use yii\helpers\Html;

?>
Hello <?= $user->username ?>,

Follow the link below to verify your email:

<?= Html::a(Html::encode(Yii::$app->params["frontend_url"] . "site/repairs"), Yii::$app->params["frontend_url"] . "site/repairs") ?>

Best regards,
The Repair Team