<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%time_slot_master}}".
 *
 * @property int $ryb_time_slot_id
 * @property string|null $ryb_time_slot_start
 * @property string|null $ryb_time_slot_end
 *
 * @property RateCardMaster[] $rateCardMasters
 */
class TimeSlotMaster extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%time_slot_master}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ryb_time_slot_start', 'ryb_time_slot_end'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'ryb_time_slot_id' => 'Ryb Time Slot ID',
            'ryb_time_slot_start' => 'Ryb Time Slot Start',
            'ryb_time_slot_end' => 'Ryb Time Slot End',
        ];
    }

    /**
     * Gets query for [[RateCardMasters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRateCardMasters() {
        return $this->hasMany(RateCardMaster::className(), ['ryb_time_slot_id' => 'ryb_time_slot_id']);
    }

}
