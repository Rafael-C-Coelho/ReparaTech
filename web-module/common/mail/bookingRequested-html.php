<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Your booking request has been received. We will get back to you shortly with a confirmation or denial.</p>

    <p>Best regards,</p>
    <p>The Repair Team</p>
</div>
