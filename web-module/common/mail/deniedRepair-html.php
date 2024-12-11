<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>You've rejected our budget proposal. If you'd like another quote, let us know, otherwise this repair is considered finished.</p>

    <p>Best regards,</p>
    <p>The Repair Team</p>
</div>
