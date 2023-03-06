<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
//use yii\web\Controller;
use common\models\Product;
use common\models\CartItem;
use frontend\base\Controller;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class CartController extends Controller
{

    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['add'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            [
                'class'=>VerbFilter::class,
                'actions'=>[
                    'delete'=>['POST','DELETE'],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            //get the items from session
            $cartItems=Yii::$app->session->get(CartItem::SESSION_KEY,[]);
        } else {
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
                ['userId' => Yii::$app->user->id]
            )
                ->asArray()
                ->all();
        }

        return $this->render('index', [
            'items' => $cartItems,
        ]);
    }

    public function actionAdd()
    {
        $id = Yii::$app->request->post('id');
        $product = Product::findOne(['id' => $id,'status'=>1]);
        if (!$product) {
            throw new NotFoundHttpException("can't find product");
        }

        if (Yii::$app->user->isGuest) {
            //Save in session

            $cartItems=Yii::$app->session->get(CartItem::SESSION_KEY,[]);
            $found=false;
            foreach($cartItems as &$item){
                if($item['id']==$id){
                    $item['quantity']++;
                    $found=true;
                    break;
                }
            }

            if(!$found){
                $cartItem=[
                    'id'=>$id,
                    'name'=>$product->name,
                    'image'=>$product->image,
                    'price'=>$product->price,
                    'quantity'=>1,
                    'total_price'=>$product->price
                ];
                $cartItems[]=$cartItem;
            }
            Yii::$app->session->set(CartItem::SESSION_KEY,$cartItems);
        } else {
            $userID = Yii::$app->user->id;
            $cartItem = CartItem::find()->userId($userID)->productId($id)->one();
            if ($cartItem) { //if product in cart item then increase quantity
                $cartItem->quantity++;
            } else {

                $cartItem = new CartItem();
                $cartItem->product_id = $id;
                $cartItem->created_by = Yii::$app->user->id;
                $cartItem->quantity = 1;
            }
            if ($cartItem->save()) {
                return [
                    'success' => true,
                ];
            } else {
                return [
                    'success' => false,
                    'errors' => $cartItem->errors,
                ];
            }
        }
    }

    public function actionDelete($id){
        if(isGuest()){
            $cartItems=Yii::$app->session->get(CartItem::SESSION_KEY,[]);
            foreach($cartItems as $i=>$cartItem){
                if($cartItem['id']==$id){
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            Yii::$app->session->set(CartItem::SESSION_KEY,$cartItems);
        }else{
            CartItem::deleteAll(['product_id'=>$id,'created_by'=>currUserId()]);
        }

        return $this->redirect(['index']);
    }


    // public function actionChangeQuantity(){
    //     $id = Yii::$app->request->post('id');
    //     $userId = Yii::$app->user->identity;
    //     $product = Product::findOne(['id' => $id,'status'=>1]);
    //     $quantity=Yii::$app->request->post('quantity');
    //     if (!$product) {
    //         throw new NotFoundHttpException("can't find product");
    //     }
    //     Yii::warning($quantity);
    //     $cartItem = CartItem::find()->where(['product_id'=>$id,'created_by'=>$userId])->one();
    //     if(!empty($cartItem)){
    //         $cartItem->quantity = $quantity;
    //         $cartItem->save();
    //     }
    //     if(isGuest()){

    //     }
    //     return $quantity;
    // }


    public function actionChangeQuantity(){
        $id = Yii::$app->request->post('id');
        $product = Product::findOne(['id' => $id,'status'=>1]);
        $quantity=Yii::$app->request->post('quantity');
        if (!$product) {
            throw new NotFoundHttpException("can't find product");
        }
        if(isGuest()){
            $cartItems= Yii::$app->session->get(CartItem::SESSION_KEY,[]);
            foreach($cartItems as &$cartItem){
                if($cartItem['id']==$id){
                    $cartItem['quantity']=$quantity;
                    break;
                }
            }
            Yii::$app->session->set(CartItem::SESSION_KEY,$cartItems);
        }else{
            $cartItem=CartItem::find()->userId(currUserId())->productId($id)->one();
            if($cartItem){
                $cartItem->quantity=$quantity;
                $cartItem->save();
            }
        }
        return CartItem::getTotalQuantityForUser(currUserId());
    }
}
