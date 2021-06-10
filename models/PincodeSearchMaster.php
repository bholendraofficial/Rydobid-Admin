<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PincodeMaster;

class PincodeSearchMaster extends PincodeMaster {

    public function rules() {
        return [
            [['ryb_pincode_id', 'ryb_status_id', 'ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_number'], 'integer'],
            [['ryb_pincode_title', 'ryb_pincode_added_at'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = PincodeMaster::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);
        if (!$this->validate()) {
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'ryb_pincode_id' => $this->ryb_pincode_id,
            'ryb_status_id' => $this->ryb_status_id,
            'ryb_country_id' => $this->ryb_country_id,
            'ryb_state_id' => $this->ryb_state_id,
            'ryb_city_id' => $this->ryb_city_id,
            'ryb_pincode_added_at' => $this->ryb_pincode_added_at,
            'ryb_pincode_number' => $this->ryb_pincode_number,
        ]);
        $query->andFilterWhere(['ilike', 'ryb_pincode_title', $this->ryb_pincode_title]);
        return $dataProvider;
    }

}
