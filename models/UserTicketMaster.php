<?php

namespace app\models;

use Yii;

class UserTicketMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%user_ticket_master}}';
    }

    public function rules() {
        return [
            [['ryb_user_id', 'ryb_user_ride_id', 'ryb_ticket_category_id', 'ryb_user_ticket_priority', 'ryb_user_ticket_status'], 'default', 'value' => null],
            [['ryb_user_id', 'ryb_user_ride_id', 'ryb_ticket_category_id', 'ryb_user_ticket_priority', 'ryb_user_ticket_status'], 'integer'],
            [['ryb_user_ticket_added_at'], 'safe'],
            [['ryb_user_ticket_title'], 'string', 'max' => 255],
            [['ryb_ticket_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => TicketCategoryMaster::className(), 'targetAttribute' => ['ryb_ticket_category_id' => 'ryb_ticket_category_id']],
            [['ryb_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserMaster::className(), 'targetAttribute' => ['ryb_user_id' => 'ryb_user_id']],
            [['ryb_user_ride_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRideMaster::className(), 'targetAttribute' => ['ryb_user_ride_id' => 'ryb_user_ride_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_user_ticket_id' => 'Ticket ID',
            'ryb_user_id' => 'User',
            'ryb_user_ride_id' => 'Ride',
            'ryb_ticket_category_id' => 'Category',
            'ryb_user_ticket_title' => 'Title',
            'ryb_user_ticket_code' => 'Code',
            'ryb_user_ticket_priority' => 'Priority',
            'ryb_user_ticket_status' => 'Status',
            'ryb_user_ticket_added_at' => 'Ticket Added At',
        ];
    }

    public function getRybTicketCategory() {
        return $this->hasOne(TicketCategoryMaster::className(), ['ryb_ticket_category_id' => 'ryb_ticket_category_id']);
    }

    public function getRybUser() {
        return $this->hasOne(UserMaster::className(), ['ryb_user_id' => 'ryb_user_id']);
    }

    public function getRybUserRide() {
        return $this->hasOne(UserRideMaster::className(), ['ryb_user_ride_id' => 'ryb_user_ride_id']);
    }

    public function getUserTicketMessages() {
        return $this->hasMany(UserTicketMessage::className(), ['ryb_user_ticket_id' => 'ryb_user_ticket_id']);
    }

}
