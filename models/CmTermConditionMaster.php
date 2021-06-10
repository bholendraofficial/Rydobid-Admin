<?php

namespace app\models;

use Yii;

class CmTermConditionMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%cm_term_condition_master}}';
    }

    public function rules() {
        return [
            [['ryb_cm_term_condition_text', 'ryb_cm_term_condition_file'], 'required'],
            [['ryb_cm_term_condition_text'], 'required', 'on' => 'update'],
            [['ryb_cm_term_condition_text', 'ryb_cm_term_condition_file'], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_cm_term_condition_id' => 'Ryb Cm Term Condition ID',
            'ryb_cm_term_condition_text' => 'Term Condition - Text',
            'ryb_cm_term_condition_file' => 'Term Condition - File',
        ];
    }

}
