<?php

namespace app\models;

use Yii;

class CmFaqMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%cm_faq_master}}';
    }

    public function rules() {
        return [
            [['ryb_cm_faq_question', 'ryb_cm_faq_answer'], 'required'],
            [['ryb_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusMaster::className(), 'targetAttribute' => ['ryb_status_id' => 'ryb_status_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_cm_faq_id' => 'Faq ID',
            'ryb_status_id' => 'Status',
            'ryb_cm_faq_question' => 'FAQ - Question',
            'ryb_cm_faq_answer' => 'FAQ - Answer',
        ];
    }

    public function getRybStatus() {
        return $this->hasOne(StatusMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

}
