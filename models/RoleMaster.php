<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%role_master}}".
 *
 * @property int $ryb_role_id
 * @property int|null $ryb_status_id
 * @property string|null $ryb_role_title
 *
 * @property AdminMaster[] $adminMasters
 * @property StatusMaster $rybStatus
 */
class RoleMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%role_master}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ryb_role_id'], 'required'],
            [['ryb_role_id', 'ryb_status_id'], 'default', 'value' => null],
            [['ryb_role_id', 'ryb_status_id'], 'integer'],
            [['ryb_role_title'], 'string', 'max' => 256],
            [['ryb_role_id'], 'unique'],
            [['ryb_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusMaster::className(), 'targetAttribute' => ['ryb_status_id' => 'ryb_status_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ryb_role_id' => 'Ryb Role ID',
            'ryb_status_id' => 'Ryb Status ID',
            'ryb_role_title' => 'Ryb Role Title',
        ];
    }

    /**
     * Gets query for [[AdminMasters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdminMasters()
    {
        return $this->hasMany(AdminMaster::className(), ['ryb_role_id' => 'ryb_role_id']);
    }

    /**
     * Gets query for [[RybStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRybStatus()
    {
        return $this->hasOne(StatusMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }
}
