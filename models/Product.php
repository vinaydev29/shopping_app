<?php

namespace app\models;

use Yii;
use app\models\ProductImages;
use yii\helpers\Url;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $files;
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'files'], 'required'],
            [['price'], 'number'],
            //[['files[]'], 'file', 'types'=>'jpg,jpeg,gif,png'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
        ];
    }
    
    public function getFiles($model)
    {
        $productImagesData = ProductImages::findAll(['product_id' => $model->id]);
        $html = '';
        $appUrl = Url::base(true);
        if (!empty($productImagesData)) {
            foreach ($productImagesData as $ind => $iVal) {
                $path = $appUrl . '/' . $iVal->image_path;
                $html .= '<a href="'.$path.'" download>'.$iVal->image_name.'</a><br>';
            }
        }
        return $html;
    }
    
}
