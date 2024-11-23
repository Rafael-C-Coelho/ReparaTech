<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Invoice $model */
/** @var common\models\User[] $repairTechnicians */
/** @var common\models\User[] $clients */
/** @var common\models\Repair[] $repairs */

$this->title = 'Create Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-create">
    <?= $this->render('_form', [
        'model' => $model,
        'repairs'  => $repairs,
        'clients' => $clients,
    ]) ?>

</div>
