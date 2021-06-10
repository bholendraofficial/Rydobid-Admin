<?php

namespace app\models;

use Yii;

class DriverCabMaster extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%driver_cab_master}}';
    }

    public function rules()
    {
        return [
            [
                [
                    'ryb_driver_cab_brand', 'ryb_driver_cab_model', 'ryb_driver_cab_make_year', 'ryb_driver_cab_exterior_color', 'ryb_driver_cab_interior_color',
                    'ryb_driver_license_no', 'ryb_driver_license_cert', 'ryb_driver_license_expiry', 'ryb_driver_cab_chasis_no', 'ryb_driver_cab_reg_no',
                    'ryb_driver_cab_reg_cert', 'ryb_driver_cab_permit_no', 'ryb_driver_cab_permit_cert', 'ryb_driver_cab_permit_expiry', 'ryb_driver_cab_insurance_no',
                    'ryb_driver_cab_insurance_cert', 'ryb_driver_cab_insurance_expiry', 'ryb_driver_id'
                ],
                'required'
            ],
            [['ryb_driver_id', 'ryb_driver_cab_status_id'], 'integer'],
            [['ryb_driver_license_cert', 'ryb_driver_cab_reg_cert', 'ryb_driver_cab_permit_cert', 'ryb_driver_cab_insurance_cert'], 'string'],
            [['ryb_driver_license_expiry', 'ryb_driver_cab_permit_expiry', 'ryb_driver_cab_insurance_expiry', 'ryb_driver_cab_added_at', 'ryb_driver_cab_status_remark'], 'safe'],
            [['ryb_driver_cab_brand', 'ryb_driver_cab_model', 'ryb_driver_cab_make_year', 'ryb_driver_cab_exterior_color', 'ryb_driver_cab_interior_color', 'ryb_driver_license_no', 'ryb_driver_cab_chasis_no', 'ryb_driver_cab_reg_no', 'ryb_driver_cab_permit_no', 'ryb_driver_cab_insurance_no'], 'string', 'max' => 255],
            [['ryb_driver_cab_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => DriverCabStatusMaster::className(), 'targetAttribute' => ['ryb_driver_cab_status_id' => 'ryb_driver_cab_status_id']],
            [['ryb_driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => DriverMaster::className(), 'targetAttribute' => ['ryb_driver_id' => 'ryb_driver_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ryb_driver_cab_id' => 'Driver Cab ID',
            'ryb_driver_id' => 'Driver',
            'ryb_driver_cab_status_id' => 'Cab Status(KYC)',
            'ryb_driver_cab_brand' => 'Cab Brand',
            'ryb_driver_cab_model' => 'Cab Model',
            'ryb_driver_cab_make_year' => 'Cab Make Year',
            'ryb_driver_cab_exterior_color' => 'Cab Exterior Color',
            'ryb_driver_cab_interior_color' => 'Cab Interior Color',
            'ryb_driver_license_no' => 'Driving License No.',
            'ryb_driver_license_cert' => 'Driving License Certificate',
            'ryb_driver_license_expiry' => 'Driving License Expiry',
            'ryb_driver_cab_chasis_no' => 'Chasis No.',
            'ryb_driver_cab_reg_no' => 'Registration No.',
            'ryb_driver_cab_reg_cert' => 'Registration Certificate',
            'ryb_driver_cab_permit_no' => 'Permit No.',
            'ryb_driver_cab_permit_cert' => 'Permit Certificate',
            'ryb_driver_cab_permit_expiry' => 'Permit Expiry',
            'ryb_driver_cab_insurance_no' => 'Insurance No.',
            'ryb_driver_cab_insurance_cert' => 'Insurance Certificate',
            'ryb_driver_cab_insurance_expiry' => 'Insurance Expiry',
            'ryb_driver_cab_added_at' => 'Vehicle Added At',
            'ryb_driver_cab_status_remark' => 'Cab Status(KYC) Remark',
        ];
    }

    public function getRybDriverCabStatus()
    {
        return $this->hasOne(DriverCabStatusMaster::className(), ['ryb_driver_cab_status_id' => 'ryb_driver_cab_status_id']);
    }

    public function getRybDriver()
    {
        return $this->hasOne(DriverMaster::className(), ['ryb_driver_id' => 'ryb_driver_id']);
    }

}
