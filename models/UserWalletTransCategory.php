<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user_wallet_trans_category}}".
 *
 * @property int $ryb_user_wallet_trans_category_id
 * @property string|null $ryb_user_wallet_trans_category_text
 *
 * @property UserWalletTransMaster[] $userWalletTransMasters
 */
class UserWalletTransCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_wallet_trans_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ryb_user_wallet_trans_category_text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ryb_user_wallet_trans_category_id' => 'Ryb User Wallet Trans Category ID',
            'ryb_user_wallet_trans_category_text' => 'Ryb User Wallet Trans Category Text',
        ];
    }

    /**
     * Gets query for [[UserWalletTransMasters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserWalletTransMasters()
    {
        return $this->hasMany(UserWalletTransMaster::className(), ['ryb_user_wallet_trans_category_id' => 'ryb_user_wallet_trans_category_id']);
    }
}
