<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CountryMaster;

class CountrySearchMaster extends CountryMaster {

    public function rules() {
        return [
            [['ryb_country_id', 'ryb_status_id'], 'integer'],
            [['ryb_country_title', 'ryb_country_added_at'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = CountryMaster::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'ryb_country_id' => $this->ryb_country_id,
            'ryb_status_id' => $this->ryb_status_id,
            'ryb_country_added_at' => $this->ryb_country_added_at,
        ]);
        $query->andFilterWhere(['ilike', 'ryb_country_title', $this->ryb_country_title]);
        return $dataProvider;
    }

}
