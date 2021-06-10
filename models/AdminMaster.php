<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%admin_master}}".
 *
 * @property int $ryb_admin_id
 * @property int|null $ryb_status_id
 * @property int $ryb_role_id
 * @property int $ryb_pincode_id
 * @property int $ryb_city_id
 * @property int $ryb_state_id
 * @property int $ryb_country_id
 * @property string|null $ryb_admin_fullname
 * @property string|null $ryb_admin_phoneno
 * @property string|null $ryb_admin_image
 * @property string|null $ryb_admin_address
 * @property string|null $ryb_admin_addedat
 * @property string|null $ryb_admin_emailid
 *
 * @property CityMaster $rybCity
 * @property CountryMaster $rybCountry
 * @property PincodeMaster $rybPincode
 * @property RoleMaster $rybRole
 * @property StateMaster $rybState
 * @property StatusMaster $rybStatus
 */
class AdminMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_master}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ryb_admin_id', 'ryb_role_id', 'ryb_pincode_id', 'ryb_city_id', 'ryb_state_id', 'ryb_country_id'], 'required'],
            [['ryb_admin_id', 'ryb_status_id', 'ryb_role_id', 'ryb_pincode_id', 'ryb_city_id', 'ryb_state_id', 'ryb_country_id'], 'default', 'value' => null],
            [['ryb_admin_id', 'ryb_status_id', 'ryb_role_id', 'ryb_pincode_id', 'ryb_city_id', 'ryb_state_id', 'ryb_country_id'], 'integer'],
            [['ryb_admin_image', 'ryb_admin_address'], 'string'],
            [['ryb_admin_addedat'], 'safe'],
            [['ryb_admin_fullname', 'ryb_admin_phoneno', 'ryb_admin_emailid'], 'string', 'max' => 256],
            [['ryb_admin_id'], 'unique'],
            [['ryb_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => CityMaster::className(), 'targetAttribute' => ['ryb_city_id' => 'ryb_city_id']],
            [['ryb_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryMaster::className(), 'targetAttribute' => ['ryb_country_id' => 'ryb_country_id']],
            [['ryb_pincode_id'], 'exist', 'skipOnError' => true, 'targetClass' => PincodeMaster::className(), 'targetAttribute' => ['ryb_pincode_id' => 'ryb_pincode_id']],
            [['ryb_role_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoleMaster::className(), 'targetAttribute' => ['ryb_role_id' => 'ryb_role_id']],
            [['ryb_state_id'], 'exist', 'skipOnError' => true, 'targetClass' => StateMaster::className(), 'targetAttribute' => ['ryb_state_id' => 'ryb_state_id']],
            [['ryb_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusMaster::className(), 'targetAttribute' => ['ryb_status_id' => 'ryb_status_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ryb_admin_id' => 'Ryb Admin ID',
            'ryb_status_id' => 'Ryb Status ID',
            'ryb_role_id' => 'Ryb Role ID',
            'ryb_pincode_id' => 'Ryb Pincode ID',
            'ryb_city_id' => 'Ryb City ID',
            'ryb_state_id' => 'Ryb State ID',
            'ryb_country_id' => 'Ryb Country ID',
            'ryb_admin_fullname' => 'Ryb Admin Fullname',
            'ryb_admin_phoneno' => 'Ryb Admin Phoneno',
            'ryb_admin_image' => 'Ryb Admin Image',
            'ryb_admin_address' => 'Ryb Admin Address',
            'ryb_admin_addedat' => 'Ryb Admin Addedat',
            'ryb_admin_emailid' => 'Ryb Admin Emailid',
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
     * Gets query for [[RybRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybRole()
    {
        return $this->hasOne(RoleMaster::className(), ['ryb_role_id' => 'ryb_role_id']);
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

    /**
     * Gets query for [[RybStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybStatus()
    {
        return $this->hasOne(StatusMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }
}
