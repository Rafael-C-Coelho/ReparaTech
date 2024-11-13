<?php

use common\models\Budget;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Repair $model */
/** @var common\models\User[] $repairTechnicians */
/** @var common\models\User[] $clients */

$this->title = 'Create Repair';
$this->params['breadcrumbs'][] = ['label' => 'Repairs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="repair-create">

    <?= $this->render('_form', [
        'model' => $model,
        'repairTechnicians' => $repairTechnicians,
        'clients' => $clients,
    ]) ?>

</div>
