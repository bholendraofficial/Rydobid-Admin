<?php

namespace app\models;

use Yii;

class CmAboutusMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%cm_aboutus_master}}';
    }

    public function rules() {
        return [
            [['ryb_cm_aboutus_text', 'ryb_cm_aboutus_file'], 'required'],
            [['ryb_cm_aboutus_text'], 'required', 'on' => 'update'],
            [['ryb_cm_aboutus_text', 'ryb_cm_aboutus_file'], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_cm_aboutus_id' => 'Ryb Cm Aboutus ID',
            'ryb_cm_aboutus_text' => 'About Us - Text',
            'ryb_cm_aboutus_file' => 'About Us - File',
        ];
    }

}
