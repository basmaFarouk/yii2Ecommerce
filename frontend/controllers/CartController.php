<?php

namespace frontend\controllers;

use common\models\CartItem;
use Yii;
use yii\web\Controller;

class CartController extends Controller{

    public function actionIndex(){
        if(Yii::$app->user->isGuest){
            //get the items from session
        }else{
            //get the items from database
            $cartItems = CartItem::findBySql(
                "SELECT
                               c.product_id as id,
                               p.image,
                               p.name,
                               p.price,
                               c.quantity,
                               p.price * c.quantity as total_price
                        FROM cart_items c
                                 LEFT JOIN products p on p.id = c.product_id
                         WHERE c.created_by = :userId",
                ['userId' => Yii::$app->user->id])
                ->asArray()
                ->all();
        }

        return $this->render('index',[
            'items'=>$cartItems,
        ]);
    }
}