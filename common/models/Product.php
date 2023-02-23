<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $image
 * @property float $price
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Product extends \yii\db\ActiveRecord
{


    /**
     * @var \yii\web\UploadedFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'status'], 'required'],
            [['description'], 'string'],
            [['imageFile'], 'image', 'extensions' => 'png, jpg, jpeg, webp', 'maxSize' => 10 * 1024 * 1024],
            [['price'], 'number'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 2000],
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
            'description' => 'Description',
            // 'image' => 'Product Image',
            'imageFile' => 'Product Image',
            'price' => 'Price',
            'status' => 'Published',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }



    /**
     * {@inheritdoc}
     * @return \common\models\query\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ProductQuery(get_called_class());
    }

    public function uploadImage() //neeeewww
    {
        $transaction = Yii::$app->db->beginTransaction();
        $image = UploadedFile::getInstance($this, 'imageFile');
        if ($image) {

            $imgName = Yii::$app->security->generateRandomString() . '.' . $image->getExtension();
            // $image->saveAs(Yii::getAlias('@productImgPath').'/'.$imgName);
            $this->image = $imgName;

            if (!$image->saveAs(Yii::getAlias('@productImgPath') . '/' . $imgName)) {
                $transaction->rollBack();

                return false;
            }
        }
        $transaction->commit();



        return true;
    }

    public function getImageUrl() //neeewww
    {
        if($this->image){

            return Yii::getAlias('@productImgUrl') . '/' . $this->image;
        }else{
            return Yii::$app->params['frontendUrl'].'/img/no_image.svg';
        }
    }


    public function getShortDescription()
    {
        return StringHelper::truncateWords(strip_tags($this->description),30);
    }

}
