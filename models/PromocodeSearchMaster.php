<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PromocodeMaster;

class PromocodeSearchMaster extends PromocodeMaster {

    public function rules() {
        return [
            [['ryb_promocode_id', 'ryb_status_id', 'ryb_promocode_disc_type', 'ryb_promocode_redemption_lmt'], 'integer'],
            [['ryb_promocode_unique', 'ryb_promocode_remark', 'ryb_promocode_date_start', 'ryb_promocode_date_end', 'ryb_promocode_added_at'], 'safe'],
            [['ryb_promocode_disc_amnt', 'ryb_promocode_min_trans_amnt', 'ryb_promocode_max_disc_amnt'], 'number'],
            [['ryb_promocode_for_new_user', 'ryb_promocode_is_date_range', 'ryb_promocode_is_ride_type', 'ryb_promocode_is_cab_type', 'ryb_promocode_is_city_type'], 'boolean'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = PromocodeMaster::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'ryb_promocode_id' => $this->ryb_promocode_id,
            'ryb_status_id' => $this->ryb_status_id,
            'ryb_promocode_disc_type' => $this->ryb_promocode_disc_type,
            'ryb_promocode_disc_amnt' => $this->ryb_promocode_disc_amnt,
            'ryb_promocode_min_trans_amnt' => $this->ryb_promocode_min_trans_amnt,
            'ryb_promocode_max_disc_amnt' => $this->ryb_promocode_max_disc_amnt,
            'ryb_promocode_redemption_lmt' => $this->ryb_promocode_redemption_lmt,
            'ryb_promocode_for_new_user' => $this->ryb_promocode_for_new_user,
            'ryb_promocode_is_date_range' => $this->ryb_promocode_is_date_range,
            'ryb_promocode_is_ride_type' => $this->ryb_promocode_is_ride_type,
            'ryb_promocode_is_cab_type' => $this->ryb_promocode_is_cab_type,
            'ryb_promocode_is_city_type' => $this->ryb_promocode_is_city_type,
            'ryb_promocode_date_start' => $this->ryb_promocode_date_start,
            'ryb_promocode_date_end' => $this->ryb_promocode_date_end,
            'ryb_promocode_added_at' => $this->ryb_promocode_added_at,
        ]);
        $query->andFilterWhere(['ilike', 'ryb_promocode_unique', $this->ryb_promocode_unique])
                ->andFilterWhere(['ilike', 'ryb_promocode_remark', $this->ryb_promocode_remark]);

        return $dataProvider;
    }

}
