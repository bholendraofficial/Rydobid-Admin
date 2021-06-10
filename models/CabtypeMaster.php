<?php

namespace app\models;

use Yii;

class CabtypeMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%cabtype_master}}';
    }

    public function rules() {
        return [
            [['ryb_cabtype_title', 'ryb_cabtype_seating', 'ryb_cabtype_icon', 'ryb_cabtype_description'], 'required', 'on' => 'create'],
            [['ryb_cabtype_title', 'ryb_cabtype_seating'], 'required'],
            [['ryb_status_id', 'ryb_cabtype_seating'], 'integer'],
            [['ryb_cabtype_added_at', 'ryb_cabtype_description'], 'safe'],
            [['ryb_cabtype_title'], 'string', 'max' => 64],
            [['ryb_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusMaster::className(), 'targetAttribute' => ['ryb_status_id' => 'ryb_status_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_cabtype_id' => 'Cab Type ID',
            'ryb_status_id' => 'Status',
            'ryb_cabtype_title' => 'Cab Type Title',
            'ryb_cabtype_description' => 'Cab Type Description',
            'ryb_cabtype_icon' => 'Cab Type Icon',
            'ryb_cabtype_seating' => 'Cab Seating Capacity',
            'ryb_cabtype_added_at' => 'Cab Type Added At',
        ];
    }

    public function getRybStatus() {
        return $this->hasOne(StatusMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

}
