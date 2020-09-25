<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\ProductImages;
use app\models\User;
use app\models\Cart;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\rest\Controller;
use yii\helpers\Url;

class CartApiController extends Controller {
    /*
      Add product for user's cart
     */

    public function actionAdd() {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $rawData = Yii::$app->request->getRawBody();
        $respData = json_decode($rawData, true);
        $userId = isset($respData['user_id']) ? $respData['user_id'] : 0;
        $user = User::find()->select(['id', 'username'])->where(['id' => $userId, 'status' => 1])->one();
        if (empty($user)) {
            return ['status' => 404, 'message' => 'Invalid user'];
        }
        $isCartUpdated = 0;
        if (isset($respData['products']) && !empty($respData['products'])) {
            foreach ($respData['products'] as $pVal) {
                $product_id = isset($pVal['product_id']) ? $pVal['product_id'] : 0;
                $quantity = isset($pVal['quantity']) ? $pVal['quantity'] : 0;
                $product = Product::find()->select(['id', 'name'])->where(['id' => $product_id])->one();
                if (!empty($product)) {
                    $cart = Cart::find()->select(['id'])->where(['product_id' => $product_id, 'user_id' => $userId])->one();
                    if (empty($cart)) {
                        $cart = new Cart();
                    }
                    $cart->product_id = $product_id;
                    $cart->user_id = $userId;
                    $cart->quantity = (int) $quantity;
                    $cart->save(false);
                    $isCartUpdated = 1;
                }
            }
        }
        if ($isCartUpdated == 1) {
            return ['status' => 200, 'message' => 'Cart updated successfully'];
        } else {
            return ['status' => 404, 'message' => 'Invalid cart products'];
        }
    }

    public function actionUserCart($userId = NULL) {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $user = User::find()->select(['id', 'username'])->where(['id' => $userId, 'status' => 1])->one();
        if (empty($user)) {
            return ['status' => 404, 'message' => 'Invalid user'];
        }
        $data = array();
        $i = 0;
        $cart = Cart::find()->where(['user_id' => $userId])->all();

        $cartData = array();
        if (!empty($cart)) {
            foreach ($cart as $cVal) {
                $product = Product::find()->select(['id', 'name'])->where(['id' => $cVal->product_id])->one();
                $cartData[$i]['product_id'] = $cVal->product_id;
                $cartData[$i]['product_name'] = $product->name;
                $cartData[$i]['quantity'] = $cVal->quantity;
                $i++;
            }
        }
        if (!empty($cartData)) {
            return ['status' => 200, 'data' => $cartData];
        } else {
            return ['status' => 404, 'message' => 'No record found.'];
        }
        return $user;
    }

}
