<?php

namespace app\models;

use app\models\UserMaster;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearchMaster extends UserMaster
{

    public function rules()
    {
        return [
            [['ryb_user_id', 'ryb_status_id', 'ryb_user_login_method', 'ryb_user_verify_code'], 'integer'],
            [['ryb_user_fullname', 'ryb_user_emailid', 'ryb_user_phoneno', 'ryb_user_password', 'ryb_user_addedat', 'ryb_user_picture', 'ryb_user_addr_home', 'ryb_user_addr_work'], 'safe'],
            [['ryb_user_verify_status'], 'boolean'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UserMaster::find()->orderBy('ryb_user_id DESC');
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'ryb_user_id' => $this->ryb_user_id,
            'ryb_status_id' => $this->ryb_status_id,
            'ryb_user_login_method' => $this->ryb_user_login_method,
            'ryb_user_verify_status' => $this->ryb_user_verify_status,
            'ryb_user_verify_code' => $this->ryb_user_verify_code,
            'ryb_user_addedat' => $this->ryb_user_addedat,
        ]);
        $query->andFilterWhere(['ilike', 'ryb_user_fullname', $this->ryb_user_fullname])
            ->andFilterWhere(['ilike', 'ryb_user_emailid', $this->ryb_user_emailid])
            ->andFilterWhere(['ilike', 'ryb_user_phoneno', $this->ryb_user_phoneno])
            ->andFilterWhere(['ilike', 'ryb_user_password', $this->ryb_user_password])
            ->andFilterWhere(['ilike', 'ryb_user_picture', $this->ryb_user_picture])
            ->andFilterWhere(['ilike', 'ryb_user_addr_home', $this->ryb_user_addr_home])
            ->andFilterWhere(['ilike', 'ryb_user_addr_work', $this->ryb_user_addr_work]);
        return $dataProvider;
    }

    public function search_driver($params)
    {
        $query = UserMaster::find()->joinWith([
            'rybDriver','rybDriver.driverCab','rybDriver.driverCab.rybDriverCabStatus'
        ])->orderBy('ryb_user_id DESC');
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->where(['ryb_user_type' => 2]);
        $query->andFilterWhere([
            'ryb_user_id' => $this->ryb_user_id,
            'ryb_status_id' => $this->ryb_status_id,
            'ryb_user_login_method' => $this->ryb_user_login_method,
            'ryb_user_verify_status' => $this->ryb_user_verify_status,
            'ryb_user_verify_code' => $this->ryb_user_verify_code,
            'ryb_user_addedat' => $this->ryb_user_addedat,
        ]);
        $query->andFilterWhere(['ilike', 'ryb_user_fullname', $this->ryb_user_fullname])
            ->andFilterWhere(['ilike', 'ryb_user_emailid', $this->ryb_user_emailid])
            ->andFilterWhere(['ilike', 'ryb_user_phoneno', $this->ryb_user_phoneno])
            ->andFilterWhere(['ilike', 'ryb_user_password', $this->ryb_user_password])
            ->andFilterWhere(['ilike', 'ryb_user_picture', $this->ryb_user_picture])
            ->andFilterWhere(['ilike', 'ryb_user_addr_home', $this->ryb_user_addr_home])
            ->andFilterWhere(['ilike', 'ryb_user_addr_work', $this->ryb_user_addr_work]);
        return $dataProvider;
    }


}
