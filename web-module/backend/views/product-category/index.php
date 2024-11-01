<?php

use common\models\ProductCategory;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Product Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-index">


    <p>
        <?= Yii::$app->user->can('createProductCategories') ? Html::a(Yii::t('app', 'Create Product Category'), ['create'], ['class' => 'btn btn-success']) : '' ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ProductCategory $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
