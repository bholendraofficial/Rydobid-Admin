<?php

namespace app\models;

use Yii;

class CmPrivacyPolicyMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%cm_privacy_policy_master}}';
    }

    public function rules() {
        return [
            [['ryb_cm_privacy_policy_text', 'ryb_cm_privacy_policy_file'], 'required'],
            [['ryb_cm_privacy_policy_text'], 'required', 'on' => 'update'],
            [['ryb_cm_privacy_policy_text', 'ryb_cm_privacy_policy_file'], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_cm_privacy_policy_id' => 'Ryb Cm Privacy Policy ID',
            'ryb_cm_privacy_policy_text' => 'Privacy Policy - Text',
            'ryb_cm_privacy_policy_file' => 'Privacy Policy - File',
        ];
    }

}
