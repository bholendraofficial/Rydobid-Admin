<?php

namespace app\models;

use Yii;

class CmCancelRefundMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%cm_cancel_refund_master}}';
    }

    public function rules() {
        return [
            [['ryb_cm_cancel_refund_text', 'ryb_cm_cancel_refund_file'], 'required'],
            [['ryb_cm_cancel_refund_text'], 'required', 'on' => 'update'],
            [['ryb_cm_cancel_refund_text', 'ryb_cm_cancel_refund_file'], 'string'],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_cm_cancel_refund_id' => 'Ryb Cm Cancel Refund ID',
            'ryb_cm_cancel_refund_text' => 'Cancel Refund - Text',
            'ryb_cm_cancel_refund_file' => 'Cancel Refund - File',
        ];
    }

}
