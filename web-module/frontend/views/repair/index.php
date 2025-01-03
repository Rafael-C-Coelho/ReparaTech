<?php

/** @var \common\models\Repair $model */
/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var \yii\web\View $this */


use yii\bootstrap4\Html;
use yii\grid\GridView;

$this->title = 'Repairs';
?>

<div>
    <div>
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    </div>
    <table  class="table" >
        <div class="repairs">
            <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'device',
                        'progress',
                        'description',
                        ['class' =>'yii\grid\ActionColumn', 'template' => '{view}',

                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('View', $url, [
                                        'class' => 'btn btn-warning',
                                        'color' => '',
                                        'title' => 'View',
                                    ]);
                                },
                            ]

                        ],
                    ]]
            )?>

        </div>
    </table>

    <a href="<?= \yii\helpers\Url::to(['site/painelClient']) ?>" type="button" style="background-color: #FFD333;"  class="btn btn-primary">
        <strong>Back</strong>
    </a>
</div>