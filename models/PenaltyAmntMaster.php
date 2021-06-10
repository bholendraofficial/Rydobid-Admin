<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%penalty_amnt_master}}".
 *
 * @property int $ryb_penalty_amnt_id
 * @property int|null $ryb_country_id
 * @property int|null $ryb_state_id
 * @property int|null $ryb_city_id
 * @property int|null $ryb_pincode_id
 * @property int|null $ryb_ride_type_id
 * @property int|null $ryb_conf_package_id
 * @property float|null $ryb_penalty_amnt
 *
 * @property CityMaster $rybCity
 * @property ConfPackageMaster $rybConfPackage
 * @property CountryMaster $rybCountry
 * @property PincodeMaster $rybPincode
 * @property RideTypeMaster $rybRideType
 * @property StateMaster $rybState
 */
class PenaltyAmntMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%penalty_amnt_master}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_id', 'ryb_ride_type_id', 'ryb_conf_package_id'], 'default', 'value' => null],
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_id', 'ryb_ride_type_id', 'ryb_conf_package_id'], 'integer'],
            [['ryb_penalty_amnt'], 'number'],
            [['ryb_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => CityMaster::className(), 'targetAttribute' => ['ryb_city_id' => 'ryb_city_id']],
            [['ryb_conf_package_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfPackageMaster::className(), 'targetAttribute' => ['ryb_conf_package_id' => 'ryb_conf_package_id']],
            [['ryb_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryMaster::className(), 'targetAttribute' => ['ryb_country_id' => 'ryb_country_id']],
            [['ryb_pincode_id'], 'exist', 'skipOnError' => true, 'targetClass' => PincodeMaster::className(), 'targetAttribute' => ['ryb_pincode_id' => 'ryb_pincode_id']],
            [['ryb_ride_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RideTypeMaster::className(), 'targetAttribute' => ['ryb_ride_type_id' => 'ryb_ride_type_id']],
            [['ryb_state_id'], 'exist', 'skipOnError' => true, 'targetClass' => StateMaster::className(), 'targetAttribute' => ['ryb_state_id' => 'ryb_state_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ryb_penalty_amnt_id' => 'Ryb Penalty Amnt ID',
            'ryb_country_id' => 'Ryb Country ID',
            'ryb_state_id' => 'Ryb State ID',
            'ryb_city_id' => 'Ryb City ID',
            'ryb_pincode_id' => 'Ryb Pincode ID',
            'ryb_ride_type_id' => 'Ryb Ride Type ID',
            'ryb_conf_package_id' => 'Ryb Conf Package ID',
            'ryb_penalty_amnt' => 'Ryb Penalty Amnt',
        ];
    }

    /**
     * Gets query for [[RybCity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybCity()
    {
        return $this->hasOne(CityMaster::className(), ['ryb_city_id' => 'ryb_city_id']);
    }

    /**
     * Gets query for [[RybConfPackage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybConfPackage()
    {
        return $this->hasOne(ConfPackageMaster::className(), ['ryb_conf_package_id' => 'ryb_conf_package_id']);
    }

    /**
     * Gets query for [[RybCountry]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybCountry()
    {
        return $this->hasOne(CountryMaster::className(), ['ryb_country_id' => 'ryb_country_id']);
    }

    /**
     * Gets query for [[RybPincode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybPincode()
    {
        return $this->hasOne(PincodeMaster::className(), ['ryb_pincode_id' => 'ryb_pincode_id']);
    }

    /**
     * Gets query for [[RybRideType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybRideType()
    {
        return $this->hasOne(RideTypeMaster::className(), ['ryb_ride_type_id' => 'ryb_ride_type_id']);
    }

    /**
     * Gets query for [[RybState]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybState()
    {
        return $this->hasOne(StateMaster::className(), ['ryb_state_id' => 'ryb_state_id']);
    }
}
