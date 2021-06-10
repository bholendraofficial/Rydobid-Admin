<?php

namespace app\models;

use Yii;

class PromocodeMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%promocode_master}}';
    }

    public function rules() {
        return [
            [
                [
                    'ryb_promocode_unique', 'ryb_promocode_remark', 'ryb_promocode_disc_type', 'ryb_promocode_disc_amnt',
                    'ryb_promocode_min_trans_amnt', 'ryb_promocode_max_disc_amnt', 'ryb_promocode_redemption_lmt'
                ],
                'required',
                'on' => 'create'
            ],
            [['ryb_promocode_unique'], 'unique', 'on' => 'create'],
            [['ryb_promocode_unique'], 'string', 'length' => 6, 'on' => 'create'],
            [
                [
                    'ryb_promocode_for_new_user', 'ryb_promocode_is_date_range',
                    'ryb_promocode_is_ride_type', 'ryb_promocode_is_cab_type',
                    'ryb_promocode_is_city_type'
                ],
                'boolean', 'on' => 'create'
            ],
            [
                [
                    'ryb_promocode_disc_amnt', 'ryb_promocode_min_trans_amnt', 'ryb_promocode_max_disc_amnt', 'ryb_promocode_redemption_lmt'
                ],
                'integer', 'min' => 1, 'on' => 'create'
            ],
            [['ryb_promocode_date_start', 'ryb_promocode_date_end'], 'safe', 'on' => 'create'],
            [['ryb_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusMaster::className(), 'targetAttribute' => ['ryb_status_id' => 'ryb_status_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_promocode_id' => 'Promocode ID',
            'ryb_status_id' => 'Status',
            'ryb_promocode_unique' => 'Promo code',
            'ryb_promocode_remark' => 'Title/Remark',
            'ryb_promocode_disc_type' => 'Discount Type',
            'ryb_promocode_disc_amnt' => 'Discount Amount',
            'ryb_promocode_min_trans_amnt' => 'Min. Transaction Amt.',
            'ryb_promocode_max_disc_amnt' => 'Max. Discount Amt.',
            'ryb_promocode_redemption_lmt' => 'Redemption Limit',
            'ryb_promocode_for_new_user' => 'For New User',
            'ryb_promocode_is_date_range' => 'Is Date Range',
            'ryb_promocode_is_ride_type' => 'Ride Type',
            'ryb_promocode_is_cab_type' => 'Cab Type',
            'ryb_promocode_is_city_type' => 'City Type',
            'ryb_promocode_date_start' => 'Start date',
            'ryb_promocode_date_end' => 'Expiry date',
            'ryb_promocode_added_at' => 'Added At',
        ];
    }

    public function getPromocodeCabTypeMasters() {
        return $this->hasMany(PromocodeCabTypeMaster::className(), ['ryb_promocode_id' => 'ryb_promocode_id']);
    }

    public function getPromocodeCityMasters() {
        return $this->hasMany(PromocodeCityMaster::className(), ['ryb_promocode_id' => 'ryb_promocode_id']);
    }

    public function getRybStatus() {
        return $this->hasOne(StatusMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

    public function getPromocodeRideTypeMasters() {
        return $this->hasMany(PromocodeRideTypeMaster::className(), ['ryb_promocode_id' => 'ryb_promocode_id']);
    }

}
