<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%bid_time_master}}".
 *
 * @property int $ryb_bid_time_id
 * @property int|null $ryb_conf_package_id
 * @property float|null $ryb_bid_time_minute
 * @property int|null $ryb_country_id
 * @property int|null $ryb_state_id
 * @property int|null $ryb_city_id
 * @property int|null $ryb_pincode_id
 *
 * @property CityMaster $rybCity
 * @property ConfPackageMaster $rybConfPackage
 * @property CountryMaster $rybCountry
 * @property PincodeMaster $rybPincode
 * @property StateMaster $rybState
 */
class BidTimeMaster extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%bid_time_master}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ryb_conf_package_id', 'ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_id'], 'default', 'value' => null],
            [['ryb_conf_package_id', 'ryb_country_id', 'ryb_state_id', 'ryb_city_id', 'ryb_pincode_id'], 'integer'],
            [['ryb_bid_time_minute'], 'number'],
            [['ryb_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => CityMaster::className(), 'targetAttribute' => ['ryb_city_id' => 'ryb_city_id']],
            [['ryb_conf_package_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfPackageMaster::className(), 'targetAttribute' => ['ryb_conf_package_id' => 'ryb_conf_package_id']],
            [['ryb_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryMaster::className(), 'targetAttribute' => ['ryb_country_id' => 'ryb_country_id']],
            [['ryb_pincode_id'], 'exist', 'skipOnError' => true, 'targetClass' => PincodeMaster::className(), 'targetAttribute' => ['ryb_pincode_id' => 'ryb_pincode_id']],
            [['ryb_state_id'], 'exist', 'skipOnError' => true, 'targetClass' => StateMaster::className(), 'targetAttribute' => ['ryb_state_id' => 'ryb_state_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'ryb_bid_time_id' => 'Ryb Bid Time ID',
            'ryb_conf_package_id' => 'Ryb Conf Package ID',
            'ryb_bid_time_minute' => 'Ryb Bid Time Minute',
            'ryb_country_id' => 'Ryb Country ID',
            'ryb_state_id' => 'Ryb State ID',
            'ryb_city_id' => 'Ryb City ID',
            'ryb_pincode_id' => 'Ryb Pincode ID',
        ];
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
     * Gets query for [[RybConfPackage]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybConfPackage() {
        return $this->hasOne(ConfPackageMaster::className(), ['ryb_conf_package_id' => 'ryb_conf_package_id']);
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
     * Gets query for [[RybState]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybState() {
        return $this->hasOne(StateMaster::className(), ['ryb_state_id' => 'ryb_state_id']);
    }

}
