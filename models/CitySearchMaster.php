<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CityMaster;

class CitySearchMaster extends CityMaster {

    public function rules() {
        return [
            [['ryb_city_id', 'ryb_status_id', 'ryb_country_id', 'ryb_state_id'], 'integer'],
            [['ryb_city_title', 'ryb_city_added_at'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = CityMaster::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'ryb_city_id' => $this->ryb_city_id,
            'ryb_status_id' => $this->ryb_status_id,
            'ryb_country_id' => $this->ryb_country_id,
            'ryb_state_id' => $this->ryb_state_id,
            'ryb_city_added_at' => $this->ryb_city_added_at,
        ]);
        $query->andFilterWhere(['ilike', 'ryb_city_title', $this->ryb_city_title]);
        return $dataProvider;
    }

}
