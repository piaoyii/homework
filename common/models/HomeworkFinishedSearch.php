<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HomeworkFinished;

/**
 * HomeworkFinishedSearch represents the model behind the search form of `common\models\HomeworkFinished`.
 */
class HomeworkFinishedSearch extends HomeworkFinished
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'homework_id', 'user_id', 'view_times', 'file_download_times'], 'integer'],
            [['content_md', 'finished_at', 'updated_at', 'file'], 'safe'],
            [['real_name'], 'string'],
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
        $query = HomeworkFinished::find()
            ->select([
                'homework_finished.homework_id',
                'user.real_name',
                'homework_finished.finished_at',
                'homework_finished.updated_at',
                'homework_finished.view_times',
                'homework_finished.user_id',
                'homework_finished.id',
            ])
            ->orderBy('homework_finished.view_times DESC')
            ->joinWith('user');
        //$query = HomeworkFinished::find();

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
            'homework_finished.status' => self::STATUS_ACTIVE,
            'id' => $this->id,
            'homework_id' => $this->homework_id,
            'user_id' => $this->user_id,
            'finished_at' => $this->finished_at,
            'updated_at' => $this->updated_at,
            'view_times' => $this->view_times,
            'file_download_times' => $this->file_download_times,
        ]);

        $query->andFilterWhere(['like', 'content_md', $this->content_md])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'user.real_name', $this->real_name]);

        return $dataProvider;
    }
}
