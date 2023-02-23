<?php
namespace backend\controllers;
// use common\models\Product;
use backend\resource\Product;
use yii\rest\ActiveController;

class ProductApiController extends ActiveController{

    public $modelClass=Product::class;
}