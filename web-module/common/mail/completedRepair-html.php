<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>We are letting you know that we've finished the repair. You can come get your device when desired.</p>

    <p>Find the invoice attached.</p>

    <p>Best regards,</p>
    <p>The Repair Team</p>
</div>
