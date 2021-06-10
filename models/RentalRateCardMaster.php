<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%rental_rate_card_master}}".
 *
 * @property int $ryb_rental_rate_card_id
 * @property int|null $ryb_country_id
 * @property int|null $ryb_state_id
 * @property int|null $ryb_city_id
 * @property int|null $ryb_pincode_id
 * @property int|null $ryb_ride_type_id
 * @property int|null $ryb_cabtype_id
 * @property float|null $ryb_rental_rate_card_1hr
 * @property float|null $ryb_rental_rate_card_2hr
 * @property float|null $ryb_rental_rate_card_3hr
 * @property float|null $ryb_rental_rate_card_4hr
 * @property float|null $ryb_rental_rate_card_5hr
 * @property float|null $ryb_rental_rate_card_6hr
 * @property float|null $ryb_rental_rate_card_7hr
 * @property float|null $ryb_rental_rate_card_8hr
 * @property float|null $ryb_rental_rate_card_9hr
 * @property float|null $ryb_rental_rate_card_10hr
 * @property float|null $ryb_rental_rate_card_11hr
 * @property float|null $ryb_rental_rate_card_12hr
 *
 * @property CabtypeMaster $rybCabtype
 * @property CityMaster $rybCity
 * @property CountryMaster $rybCountry
 * @property PincodeMaster $rybPincode
 * @property RideTypeMaster $rybRideType
 * @property StateMaster $rybState
 */
class RentalRateCardMaster extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%rental_rate_card_master}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_id', 'ryb_ride_type_id', 'ryb_cabtype_id'], 'default', 'value' => null],
            [['ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_id', 'ryb_ride_type_id', 'ryb_cabtype_id'], 'integer'],
            [['ryb_rental_rate_card_1hr', 'ryb_rental_rate_card_2hr', 'ryb_rental_rate_card_3hr', 'ryb_rental_rate_card_4hr', 'ryb_rental_rate_card_5hr', 'ryb_rental_rate_card_6hr', 'ryb_rental_rate_card_7hr', 'ryb_rental_rate_card_8hr', 'ryb_rental_rate_card_9hr', 'ryb_rental_rate_card_10hr', 'ryb_rental_rate_card_11hr', 'ryb_rental_rate_card_12hr'], 'number'],
            [['ryb_cabtype_id'], 'exist', 'skipOnError' => true, 'targetClass' => CabtypeMaster::className(), 'targetAttribute' => ['ryb_cabtype_id' => 'ryb_cabtype_id']],
            [['ryb_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => CityMaster::className(), 'targetAttribute' => ['ryb_city_id' => 'ryb_city_id']],
            [['ryb_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryMaster::className(), 'targetAttribute' => ['ryb_country_id' => 'ryb_country_id']],
            [['ryb_pincode_id'], 'exist', 'skipOnError' => true, 'targetClass' => PincodeMaster::className(), 'targetAttribute' => ['ryb_pincode_id' => 'ryb_pincode_id']],
            [['ryb_ride_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RideTypeMaster::className(), 'targetAttribute' => ['ryb_ride_type_id' => 'ryb_ride_type_id']],
            [['ryb_state_id'], 'exist', 'skipOnError' => true, 'targetClass' => StateMaster::className(), 'targetAttribute' => ['ryb_state_id' => 'ryb_state_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'ryb_rental_rate_card_id' => 'Ryb Rental Rate Card ID',
            'ryb_country_id' => 'Ryb Country ID',
            'ryb_state_id' => 'Ryb State ID',
            'ryb_city_id' => 'Ryb City ID',
            'ryb_pincode_id' => 'Ryb Pincode ID',
            'ryb_ride_type_id' => 'Ryb Ride Type ID',
            'ryb_cabtype_id' => 'Ryb Cabtype ID',
            'ryb_rental_rate_card_1hr' => 'Ryb Rental Rate Card 1hr',
            'ryb_rental_rate_card_2hr' => 'Ryb Rental Rate Card 2hr',
            'ryb_rental_rate_card_3hr' => 'Ryb Rental Rate Card 3hr',
            'ryb_rental_rate_card_4hr' => 'Ryb Rental Rate Card 4hr',
            'ryb_rental_rate_card_5hr' => 'Ryb Rental Rate Card 5hr',
            'ryb_rental_rate_card_6hr' => 'Ryb Rental Rate Card 6hr',
            'ryb_rental_rate_card_7hr' => 'Ryb Rental Rate Card 7hr',
            'ryb_rental_rate_card_8hr' => 'Ryb Rental Rate Card 8hr',
            'ryb_rental_rate_card_9hr' => 'Ryb Rental Rate Card 9hr',
            'ryb_rental_rate_card_10hr' => 'Ryb Rental Rate Card 10hr',
            'ryb_rental_rate_card_11hr' => 'Ryb Rental Rate Card 11hr',
            'ryb_rental_rate_card_12hr' => 'Ryb Rental Rate Card 12hr',
        ];
    }

    /**
     * Gets query for [[RybCabtype]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybCabtype() {
        return $this->hasOne(CabtypeMaster::className(), ['ryb_cabtype_id' => 'ryb_cabtype_id']);
    }

    /**
     * Gets query for [[RybCity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybCity() {
        return $this->hasOne(CityMaster::className(), ['ryb_city_id' => 'ryb_city_id']);
    }

    /**
     * Gets query for [[RybCountry]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybCountry() {
        return $this->hasOne(CountryMaster::className(), ['ryb_country_id' => 'ryb_country_id']);
    }

    /**
     * Gets query for [[RybPincode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybPincode() {
        return $this->hasOne(PincodeMaster::className(), ['ryb_pincode_id' => 'ryb_pincode_id']);
    }

    /**
     * Gets query for [[RybRideType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybRideType() {
        return $this->hasOne(RideTypeMaster::className(), ['ryb_ride_type_id' => 'ryb_ride_type_id']);
    }

    /**
     * Gets query for [[RybState]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybState() {
        return $this->hasOne(StateMaster::className(), ['ryb_state_id' => 'ryb_state_id']);
    }

}
