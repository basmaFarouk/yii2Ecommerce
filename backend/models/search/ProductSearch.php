<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;
use Yii;

/**
 * ProductSearch represents the model behind the search form of `common\models\Product`.
 */
class ProductSearch extends Product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['name', 'description', 'image', 'created_at', 'updated_at'], 'safe'],
            [['price'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
           'id' => $this->id,
           'name' => $this->name,
            // 'price' => $this->price,
            'status' => $this->status,
            //  'created_at' => $this->created_at,
          //  'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);
        // if($this->created_at){
        //     //use kartik date datepicker yii2
        //     var_dump($this->created_at);
        //     // var_dump(date('d/m/Y H:i:s',$this->created_at));
        //     var_dump(date('d/m/Y H:i:s', 1676764800));
        //     var_dump(strtotime($this->created_at.'24:59:59'));
        //     exit;
        // }
        // var_dump($this->name);
        // exit;
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image]);

        if ($this->price) {
            $price1 = explode('-', $this->price)[0];
            $price2 = explode('-', $this->price)[1];
            $query->andFilterWhere(['between', 'price', $price1, $price2]);
        }
        if ($this->created_at) {
            $created_at1 = strtotime($this->created_at . '00:00:00');
            $created_at2 = strtotime($this->created_at . '23:59:59');
            $query->andFilterWhere(['between', 'created_at', $created_at1, $created_at2]);
        }
        if ($this->updated_at) {
            $updated_at1 = strtotime($this->updated_at . '00:00:00');
            $updated_at2 = strtotime($this->updated_at . '23:59:59');
            $query->andFilterWhere(['between', 'updated_at', $updated_at1, $updated_at2]);
        }
        // ->andFilterWhere(['like', 'price', $this->price]);

        return $dataProvider;
    }
}
