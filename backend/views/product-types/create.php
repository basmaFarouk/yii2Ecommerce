<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductTypes $model */

$this->title = 'Create Product Types';
$this->params['breadcrumbs'][] = ['label' => 'Product Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
