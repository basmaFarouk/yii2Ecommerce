<?php

namespace frontend\base;

use common\models\CartItem;
use Yii;
use yii\web\Controller as WebController;

class Controller extends WebController
{

    public function beforeAction($action)
    {
        $this->view->params['cartItemCount']=CartItem::getTotalQuantityForUser(currUserId());
        return parent::beforeAction($action);
    }
}
