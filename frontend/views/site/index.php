<?php

/** @var yii\web\View $this */

use yii\bootstrap5\LinkPager;
use yii\widgets\ListView;

/** @var \yii\data\ActiveDataProvider $dataProvider */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <!-- <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Congratulations!</h1>
            <p class="fs-5 fw-light">You have successfully created your Yii-powered application.</p>
            <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
        </div>
    </div> -->

    <div class="body-content">


            <?php echo ListView::widget([
                'dataProvider' => $dataProvider,
                'layout'=> "{summary}\n<div class='row'>{items}</div>\n{pager}",
                'itemView'=>'_product_item',
                // 'options'=>[
                //     'class'=>'row'
                // ],
                'itemOptions'=>[
                    'class'=>'col-lg-4 col-md-6 mb-4'
                ],
                'pager'=>[
                    'class'=>LinkPager::class
                ]
            ]) ?>



    </div>
</div>