<?php

namespace app\models;

use Yii;

class TicketCategoryMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%ticket_category_master}}';
    }

    public function rules() {
        return [
            [['ryb_ticket_category_text'], 'string', 'max' => 256],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_ticket_category_id' => 'Ticket Category ID',
            'ryb_ticket_category_text' => 'Ticket Category Title',
        ];
    }

    public function getUserTicketMasters() {
        return $this->hasMany(UserTicketMaster::className(), ['ryb_ticket_category_id' => 'ryb_ticket_category_id']);
    }

}
