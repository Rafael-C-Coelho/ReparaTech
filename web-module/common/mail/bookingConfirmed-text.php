<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\Booking $booking */

use yii\helpers\Html;

?>
Hello <?= $user->username ?>,

Your booking request has been confirmed. We look forward to seeing you on <?= $booking->date ?> at <?= $booking->time ?>.

Best regards,
The Repair Team