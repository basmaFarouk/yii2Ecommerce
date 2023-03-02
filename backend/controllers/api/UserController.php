<?php
namespace backend\controllers\api;

use backend\resource\User ;
use yii\rest\ActiveController;

class UserController extends ActiveController{
    
    public $modelClass=User::class;
}