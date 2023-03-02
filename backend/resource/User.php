<?php

namespace backend\resource;

use common\models\Product as ModelsProduct;
use common\models\User as ModelsUser;

class User extends ModelsUser
{

    public function fields()
    {
        return ['id', 'firstname', 'lastname', 'email'];
    }

    public function extraFields()
    {
        return ['created_at', 'updated_at', 'addresses'];
    }

    // User has many addresses
    public function getAddresses() //override the relation to get specific fields
    {
        return $this->hasMany(UserAddress::class, ['user_id' => 'id']);
    }
}
