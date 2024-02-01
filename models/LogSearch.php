<?php

namespace nahard\log\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use nahard\log\models\Log;

/**
 * LogSearch represents the model behind the search form of `nahard\log\models\Log`.
 */
class LogSearch extends Log
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level', 'created_at', 'updated_at', 'user_id', 'status'], 'integer'],
            [['category', 'ip', 'message', 'var', 'referrer_url', 'request_url'], 'safe'],
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
        $query = Log::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => Yii::$app->request->get('dynamicPageSize', 40),
			],
			'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
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
            'level' => $this->level,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'var', $this->var])
            ->andFilterWhere(['like', 'referrer_url', $this->referrer_url])
            ->andFilterWhere(['like', 'request_url', $this->request_url]);

        return $dataProvider;
    }
}
