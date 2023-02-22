<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Product;
use yii\grid\ActionColumn;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;

/** @var yii\web\View $this */
/** @var backend\models\search\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'id',
                'contentOptions'=>[
                    'style'=>'width:70px'
                ]
            ],
            [
                'attribute'=>'name',
                'filter'=>Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'name',
                    'data' => ArrayHelper::map(Product::find()->all(), 'name', 'name'),
                    'options' => [
                        'placeholder' => 'Select a name ...',

                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])
            ],
           // 'name',
            //'description:ntext',
            // 'image',
            [
                'attribute'=>'image',
                'label'=>'Image',
                'content' => function($model){
                    /** @var \common\models\Product $model */
                    return Html::img($model->getImageUrl(),['style'=>'width:50px']);
                }
            ],
            'price:currency',
           // 'price',
            [
                'attribute'=>'status',
                'content' => function($model){
                    /** @var \common\models\Product $model */
                    return Html::tag('span', $model->status ? 'Active' : 'Draft', [
                        'class' => $model->status ? 'badge badge-success' : 'badge badge-danger'
                    ]);
                }
            ],
            [
                'attribute'=>'created_at',
                'format'=>[
                    'datetime'
                ],
                'filter'=> DatePicker::widget([
                    'name' => 'created_at',
                    'attribute'=>'created_at',
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'model'=>$searchModel,
                    // 'value' => '23-Feb-1982',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-mm-yyyy'
                    ]
                    ]),
                'contentOptions'=>['style'=>'white-space: nowrap']
            ],
            [
                'attribute'=>'updated_at',
                'format'=>[
                    'datetime'
                ],
                'filter'=> DatePicker::widget([
                    'name' => 'updated_at',
                    'attribute'=>'updated_at',
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'model'=>$searchModel,
                    // 'value' => '23-Feb-1982',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-mm-yyyy'
                    ]
                    ]),
                'contentOptions'=>['style'=>'white-space: nowrap']
            ],
            //'created_by',
            //'updated_by',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>