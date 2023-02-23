<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product_types}}".
 *
 * @property int $id
 * @property int $product_id
 * @property string $size
 * @property string $weight
 * @property string $color
 */
class ProductTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_types}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          //  [[ 'size', 'weight', 'color'], 'required'],
            [['product_id'], 'integer'],
            [['size', 'weight', 'color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'size' => 'Size',
            'weight' => 'Weight',
            'color' => 'Color',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProductTypesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductTypesQuery(get_called_class());
    }
}
