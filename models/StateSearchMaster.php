<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StateMaster;

class StateSearchMaster extends StateMaster {

    public function rules() {
        return [
            [['ryb_state_id', 'ryb_status_id', 'ryb_country_id'], 'integer'],
            [['ryb_state_title', 'ryb_state_added_at'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = StateMaster::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);
        if (!$this->validate()) {
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'ryb_state_id' => $this->ryb_state_id,
            'ryb_status_id' => $this->ryb_status_id,
            'ryb_country_id' => $this->ryb_country_id,
            'ryb_state_added_at' => $this->ryb_state_added_at,
        ]);
        $query->andFilterWhere(['ilike', 'ryb_state_title', $this->ryb_state_title]);
        return $dataProvider;
    }

}
