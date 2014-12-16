<?php

namespace yincart\order\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yincart\order\models\Order;

/**
 * OrderSearch represents the model behind the search form about `yincart\order\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'create_at', 'update_at', 'status'], 'integer'],
            [['total_price', 'shipping_fee', 'payment_fee'], 'number'],
            [['address', 'memo'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'total_price' => $this->total_price,
            'shipping_fee' => $this->shipping_fee,
            'payment_fee' => $this->payment_fee,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'memo', $this->memo]);

        return $dataProvider;
    }
}