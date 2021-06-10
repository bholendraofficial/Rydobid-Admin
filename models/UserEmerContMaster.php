<?php

namespace app\models;

use Yii;

class UserEmerContMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%user_emer_cont_master}}';
    }

    public function rules() {
        return [
            [['ryb_user_emer_cont_name', 'ryb_user_emer_cont_no'], 'required', 'on' => 'api_add'],
            [['ryb_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusMaster::className(), 'targetAttribute' => ['ryb_status_id' => 'ryb_status_id']],
            [['ryb_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['ryb_user_id' => 'ryb_user_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_user_emer_cont_id' => 'Emergency Contacct ID',
            'ryb_user_id' => 'User',
            'ryb_status_id' => 'Status',
            'ryb_user_emer_cont_name' => 'Contact name',
            'ryb_user_emer_cont_no' => 'Contact no',
            'ryb_user_emer_cont_pic' => 'Picture',
            'ryb_user_emer_cont_is_active' => 'Status',
        ];
    }

    public function getRybStatus() {
        return $this->hasOne(StatusMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

    public function getRybUser() {
        return $this->hasOne(UserMaster::className(), ['ryb_user_id' => 'ryb_user_id']);
    }

}
