<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\Booking $booking */

?>
<div>
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Your booking request has been confirmed. We look forward to seeing you on <?= date('d/m/y', $booking->date) ?> at <?= $booking->time ?>.</p>

    <p>Best regards,</p>
    <p>The Repair Team</p>
</div>
