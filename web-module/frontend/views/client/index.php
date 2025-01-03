<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Personal Information';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'name',
            'nif',
            'address',
            'contact',
            [
                'label' => 'Actions',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Update Informations', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                },
            ],
        ],
    ]); ?>


</div>
