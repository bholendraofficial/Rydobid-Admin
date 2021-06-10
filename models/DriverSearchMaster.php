<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DriverMaster;

class DriverSearchMaster extends DriverMaster
{
    public function rules()
    {
        return [
            [['ryb_driver_id', 'ryb_user_id'], 'integer'],
            [['ryb_driver_registered_at'], 'safe'],
            [['ryb_driver_is_online', 'ryb_driver_pref_is_daily', 'ryb_driver_pref_is_outstation', 'ryb_driver_pref_is_rental', 'ryb_driver_pref_is_airport'], 'boolean'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DriverMaster::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'ryb_driver_id' => $this->ryb_driver_id,
            'ryb_driver_registered_at' => $this->ryb_driver_registered_at,
            'ryb_user_id' => $this->ryb_user_id,
            'ryb_driver_is_online' => $this->ryb_driver_is_online,
            'ryb_driver_pref_is_daily' => $this->ryb_driver_pref_is_daily,
            'ryb_driver_pref_is_outstation' => $this->ryb_driver_pref_is_outstation,
            'ryb_driver_pref_is_rental' => $this->ryb_driver_pref_is_rental,
            'ryb_driver_pref_is_airport' => $this->ryb_driver_pref_is_airport,
        ]);
        return $dataProvider;
    }
}
