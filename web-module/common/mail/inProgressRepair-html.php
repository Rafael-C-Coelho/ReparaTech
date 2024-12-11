<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>You've accepted our budget proposal! We are now starting your repair and will let you know when we have updates.</p>

    <p>Best regards,</p>
    <p>The Repair Team</p>
</div>
