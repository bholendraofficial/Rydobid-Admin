<?php

namespace app\models;

use Yii;

class TaxMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%tax_master}}';
    }

    public function rules() {
        return [
            [['ryb_country_id'], 'default', 'value' => null],
            [['ryb_country_id'], 'integer'],
            [['ryb_tax_percentage'], 'number'],
            [['ryb_country_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryMaster::className(), 'targetAttribute' => ['ryb_country_id' => 'ryb_country_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_tax_id' => 'Ryb Tax ID',
            'ryb_country_id' => 'Country',
            'ryb_tax_percentage' => 'GST TAX percentage(%) for ride',
        ];
    }

    public function getRybCountry() {
        return $this->hasOne(CountryMaster::className(), ['ryb_country_id' => 'ryb_country_id']);
    }

}
