<?php
namespace backend\resource;

use common\models\Product as ModelsProduct;

class Product extends ModelsProduct{

    public function fields()
    {
        return ['id','name','description'];
    }

    public function extraFields()
    {
        return ['created_at','updated_at'];
    }
}