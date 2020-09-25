<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\ProductImages;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\rest\Controller;
use yii\helpers\Url;

class ProductApiController extends Controller {

    public function actionAllProducts() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $queryData = [];
        $productData = Product::find()->all();
        $data = array();
        $i = 0;
        $appUrl = Url::base(true);
        if (!empty($productData)) {
            foreach ($productData as $pVal) {
                $data[$i]['id'] = $pVal['id'];
                $data[$i]['name'] = $pVal['name'];
                $data[$i]['price'] = $pVal['price'];
                $productImagesData = ProductImages::findAll(['product_id' => $pVal->id]);
                $imagesData = array();
                if (!empty($productImagesData)) {
                    foreach ($productImagesData as $ind => $iVal) {
                        $imagesData[$ind]['image_name'] = $iVal->image_name;
                        $imagesData[$ind]['image_path'] = $appUrl . '/' . $iVal->image_path;
                    }
                }
                $data[$i]['images'] = $imagesData;
                $i++;
            }
            return ['status' => 200, 'data' => $data];
        } else {
            return ['status' => 404, 'message' => 'no record found'];
        }
    }

}
