<?php

use backend\resource\Product;
use yii\rest\ActiveController;

class ProductControllerApi extends ActiveController{
    
    public $modelclass=Product::class;
}