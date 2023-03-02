<?php
namespace backend\controllers\api;

use backend\resource\UserAddress;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class UserAddressController extends ActiveController{
    
    public $modelClass=UserAddress::class;


    //for return address for specific user
    public function actions()
    {
        $actions=parent::actions();
        $actions['index']['prepareDataProvider'] = [$this,'prepareDataProvider'];
        return $actions;
    }

    public function prepareDataProvider(){
        return new ActiveDataProvider([
           // 'query'=>UserAddress::find()->andWhere(['user_id'=>Yii::$app->request->get('userid')]),
           'query'=>$this->modelClass::find()->andWhere(['user_id'=>Yii::$app->request->get('userid')]),
        ]);
    }
}