<?php
namespace backend\resource;

use common\models\UserAddress as ModelsUserAddress;

class UserAddress extends ModelsUserAddress{

    public function fields()
    {
        return ['id','address','city','user_id'];
    }

    // public function extraFields()
    // {
    //     return ['created_at','updated_at'];
    // }
}