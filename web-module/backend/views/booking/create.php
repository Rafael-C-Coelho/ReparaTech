<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Booking $model */

$this->title = 'Create Booking';
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="booking-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
