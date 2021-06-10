<?php

namespace app\models;

use Yii;

class UserTicketMessage extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%user_ticket_message}}';
    }

    public function rules() {
        return [
            [['ryb_user_ticket_id', 'ryb_user_id'], 'default', 'value' => null],
            [['ryb_user_ticket_id', 'ryb_user_id'], 'integer'],
            [['ryb_user_ticket_message_text'], 'string'],
            [['ryb_user_ticket_message_added_at'], 'safe'],
            [['ryb_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['ryb_user_id' => 'ryb_user_id']],
            [['ryb_user_ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserTicketMaster::className(), 'targetAttribute' => ['ryb_user_ticket_id' => 'ryb_user_ticket_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_user_ticket_message_id' => 'Ryb User Ticket Message ID',
            'ryb_user_ticket_id' => 'Ticket',
            'ryb_user_id' => 'User',
            'ryb_user_ticket_message_text' => 'Message',
            'ryb_user_ticket_message_added_at' => 'Message Added At',
        ];
    }

    public function getRybUser() {
        return $this->hasOne(UserMaster::className(), ['ryb_user_id' => 'ryb_user_id']);
    }

    public function getRybUserTicket() {
        return $this->hasOne(UserTicketMaster::className(), ['ryb_user_ticket_id' => 'ryb_user_ticket_id']);
    }

}
