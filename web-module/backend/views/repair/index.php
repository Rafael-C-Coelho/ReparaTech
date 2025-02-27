<?php

use common\models\Repair;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Repairs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repair-index">
    <p>
        <?= Html::a('Create Repair', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'device',
            'progress',
            'hours_spent_working',
            'repairman_id',
            'client_id',
            'description',
            [
                'class' => ActionColumn::className(),
                'template'=> '{view} {update}',
                'urlCreator' => function ($action, Repair $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
