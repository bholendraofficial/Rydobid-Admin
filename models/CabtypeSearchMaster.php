<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CabtypeMaster;

class CabtypeSearchMaster extends CabtypeMaster {

    public function rules() {
        return [
            [['ryb_cabtype_id', 'ryb_status_id', 'ryb_cabtype_seating'], 'integer'],
            [['ryb_cabtype_title', 'ryb_cabtype_icon', 'ryb_cabtype_added_at'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = CabtypeMaster::find();
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);

        if (!$this->validate()) {
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'ryb_cabtype_id' => $this->ryb_cabtype_id,
            'ryb_status_id' => $this->ryb_status_id,
            'ryb_cabtype_seating' => $this->ryb_cabtype_seating,
            'ryb_cabtype_added_at' => $this->ryb_cabtype_added_at,
        ]);
        $query->andFilterWhere(['like', 'ryb_cabtype_title', $this->ryb_cabtype_title])->andFilterWhere(['ilike', 'ryb_cabtype_icon', $this->ryb_cabtype_icon]);
        return $dataProvider;
    }

}
