<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;

/**
 * @var \common\models\User $user
 * @var \common\models\UserAddress $userAddress
 */
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Address Information
            </div>
            <div class="card-body">
                <?php Pjax::begin([
                    'enablePushState' => false, //not to change the url
                ]) ?>
                <?php echo $this->render('user_address', [
                    'userAddress' => $userAddress,
                ]) ?>
            </div>
            <?php Pjax::end() ?>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                Account Information
            </div>
            <div class="card-body">
                <?php Pjax::begin([
                    'enablePushState' => false, //not to change the url
                ]) ?>
                <?php echo $this->render('user_account', [
                    'user' => $user,
                ]) ?>
            </div>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>