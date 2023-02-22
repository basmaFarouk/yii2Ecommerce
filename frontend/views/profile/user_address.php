<?php

use yii\widgets\Pjax;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
?>



<?php if (isset($success) && $success) : ?>
    <div class="alert alert-success">
        Your Address was successfully updated
    </div>
<?php endif ?>
<?php $addressForm = ActiveForm::begin([
    'action' => ['/profile/update-address'],
    'options' => [
        'data-pjax' => 1,
    ]
]); ?>
<?= $addressForm->field($userAddress, 'address') ?>
<?= $addressForm->field($userAddress, 'city') ?>
<?= $addressForm->field($userAddress, 'state') ?>
<?= $addressForm->field($userAddress, 'country') ?>
<?= $addressForm->field($userAddress, 'zipcode') ?>
<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end() ?>
