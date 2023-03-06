<?php

namespace frontend\base;

use common\models\CartItem;
use Yii;
use yii\web\Controller as WebController;

class Controller extends WebController
{

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);
            $sum = 0;
            foreach ($cartItems as $cartItem) { //to show the items quantity of the guest
                $sum += $cartItem['quantity'];
            }
        } else {

            $sum = CartItem::findBySql(
                "SELECT SUM(quantity) FROM cart_items WHERE created_by = :userId",
                ['userId' => Yii::$app->user->id]
            )->scalar();
        }
        $this->view->params['cartItemCount']=$sum;
        return parent::beforeAction($action);
    }
}
