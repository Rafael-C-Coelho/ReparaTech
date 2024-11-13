<?php

use common\models\RepairPart;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Repair Parts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repair-part-index">
    <p>
        <?= Html::a('Create Repair Part', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'repair_id',
            'part_id',
            'quantity',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, RepairPart $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
