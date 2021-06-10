<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RideTypeMaster;

class RideTypeSearchMaster extends RideTypeMaster {

    public function rules() {
        return [
            [['ryb_ride_type_title'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = RideTypeMaster::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'ryb_ride_type_title', $this->ryb_ride_type_title]);
        return $dataProvider;
    }

}
