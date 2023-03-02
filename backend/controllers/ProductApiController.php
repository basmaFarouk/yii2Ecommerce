<?php

namespace backend\controllers;
// use common\models\Product;
use Yii;
use backend\resource\Product;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\filters\auth\HttpBearerAuth;

//product-api -> Product-Api -> ProductApi -> ProductApiController -> \backend\controller\ProductApiController
class ProductApiController extends ActiveController
{

    public $modelClass = Product::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // $behaviors['authenticator'] =[
        //     'class'=>HttpBearerAuth::class,
        // ];
        $behaviors['authenticator']['only'] = ['create', 'update', 'delete'];
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if (in_array($action, ['update', 'delete']) && $model->created_by !== Yii::$app->user->id) {
            throw new ForbiddenHttpException("you don't have permission to do that");
        }
    }


    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            'searchModel' => $this->modelClass,
        ];

        return $actions;
    }
}
