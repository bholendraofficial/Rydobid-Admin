<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AirportMaster;

class AirportSearchMaster extends AirportMaster {

    public function rules() {
        return [
            [['ryb_airport_id'], 'integer'],
            [['ryb_airport_name', 'ryb_airport_added_at'], 'safe'],
            [['ryb_airport_latitude', 'ryb_airport_longitude'], 'number'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = AirportMaster::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'ryb_airport_id' => $this->ryb_airport_id,
            'ryb_airport_latitude' => $this->ryb_airport_latitude,
            'ryb_airport_longitude' => $this->ryb_airport_longitude,
            'ryb_airport_added_at' => $this->ryb_airport_added_at,
        ]);
        $query->andFilterWhere(['ilike', 'ryb_airport_name', $this->ryb_airport_name]);
        return $dataProvider;
    }

}
