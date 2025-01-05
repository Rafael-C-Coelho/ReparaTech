<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\Booking $booking */

use yii\helpers\Html;

?>
Hello <?= $user->username ?>,

Your booking request has been denied for <?= date('d/m/y', $booking->date) ?> at <?= $booking->time ?>. We apologize for any inconvenience this may cause.

Best regards,
The Repair Team