<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use wbraganca\dynamicform\DynamicFormWidget;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id' => 'dynamic-form'
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::class, [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'type' => 'number']) ?>

    <?= $form->field($model, 'status')->checkbox() ?>


    <div class="row p-3">
        <div class="card">
        <div class="panel panel-default">
            <div class="card-header">
            <div class="panel-heading">
                <h4><i class="glyphicon glyphicon-envelope"></i> Choose Product Types</h4>
                <!-- <button type="button" class="add-item btn btn-success btn-xs"><i class="fas fa-plus"></i></button> -->
            </div>
            </div>
            <!-- <hr> -->
            <div class="card-body">
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 10, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsProductTypes[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'size',
                        'weight',
                        'color',
                    ],
                ]); ?>

                <div class="container-items"><!-- widgetContainer -->
                <button type="button" class="add-item btn btn-success btn-xs"><i class="fas fa-plus"></i></button>
                    <?php foreach ($modelsProductTypes as $i => $modelProductType) : ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="card">
                            <div class="card-header">
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left pb-2">Product Types</h3>
                                <div class="pull-right pb-3">
                                  
                                    <button type="button" class="remove-item btn btn-danger btn-xs text-right"><i class="fas fa-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            </div>
                            <div class="card-body">
                            <div class="panel-body">
                                <?php
                                // necessary for update action.
                                if (!$modelProductType->isNewRecord) {
                                    echo Html::activeHiddenInput($modelProductType, "[{$i}]id");
                                }
                                ?>
                                <!-- <?= $form->field($modelProductType, "[{$i}]size")->textInput(['maxlength' => true]) ?> -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <?= $form->field($modelProductType, "[{$i}]size")->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $form->field($modelProductType, "[{$i}]weight")->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= $form->field($modelProductType, "[{$i}]color")->textInput(['maxlength' => true]) ?>
                                    </div>
                                </div><!-- .row -->
                            </div>
                            </div>
                        </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
            </div>
            </div>
        </div>

    </div>
    
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
    <?php ActiveForm::end(); ?>

</div>