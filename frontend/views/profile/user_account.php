<?php

use yii\widgets\Pjax;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
?>

<?php if (isset($success) && $success) : ?>
    <div class="alert alert-success">
        Your Account was successfully updated
    </div>
<?php endif ?>

<?php $form = ActiveForm::begin([
    'action' => ['/profile/update-account'],
    'options' => [
        'data-pjax' => 1,
    ]
]); ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($user, 'firstname')->textInput(['autofocus' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($user, 'lastname')->textInput(['autofocus' => true]) ?>
    </div>
</div>
<?= $form->field($user, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($user, 'email') ?>

<div class="row">
    <div class="col">
        <?= $form->field($user, 'password')->passwordInput() ?>
    </div>
    <div class="col">
        <?= $form->field($user, 'passwordConfirm')->passwordInput() ?>
    </div>
</div>
<!-- 
<button type="submit">Update</button> -->
<div class="form-group">
    <?= Html::submitButton('Change', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
