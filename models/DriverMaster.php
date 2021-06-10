<?php

namespace app\models;

use Yii;

class DriverMaster extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%driver_master}}';
    }

    public function rules()
    {
        return [
            [['ryb_driver_registered_at'], 'safe'],
            [['ryb_user_id'], 'default', 'value' => null],
            [['ryb_user_id'], 'integer'],
            [['ryb_driver_is_online', 'ryb_driver_pref_is_daily', 'ryb_driver_pref_is_outstation', 'ryb_driver_pref_is_rental', 'ryb_driver_pref_is_airport'], 'boolean'],
            [['ryb_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['ryb_user_id' => 'ryb_user_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ryb_driver_id' => 'Driver ID',
            'ryb_driver_registered_at' => 'Registered At',
            'ryb_user_id' => 'User',
            'ryb_driver_is_online' => ' Online',
            'ryb_driver_pref_is_daily' => 'Preference - Daily',
            'ryb_driver_pref_is_outstation' => 'Preference - Outstation',
            'ryb_driver_pref_is_rental' => 'Preference - Rental',
            'ryb_driver_pref_is_airport' => 'Preference - Airport',
        ];
    }

    public function getDriverCab()
    {
        return $this->hasOne(DriverCabMaster::className(), ['ryb_driver_id' => 'ryb_driver_id']);
    }

    public function getRybUser()
    {
        return $this->hasOne(UserMaster::className(), ['ryb_user_id' => 'ryb_user_id']);
    }

    public function getUserRideBidMasters()
    {
        return $this->hasMany(UserRideBidMaster::className(), ['ryb_driver_id' => 'ryb_driver_id']);
    }

    public function getUserRideRatingMasters()
    {
        return $this->hasMany(UserRideRatingMaster::className(), ['ryb_driver_id' => 'ryb_driver_id']);
    }

}
