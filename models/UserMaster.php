<?php

namespace app\models;

use Yii;

class UserMaster extends \yii\db\ActiveRecord {

    public static function tableName() {
        return '{{%user_master}}';
    }

    public function rules() {
        return [
            [['ryb_user_fullname', 'ryb_user_emailid', 'ryb_user_phoneno', 'ryb_user_password', 'ryb_user_login_method'], 'required', 'on' => 'api_register'],
            [['ryb_user_fullname', 'ryb_user_emailid', 'ryb_user_phoneno'], 'string', 'max' => 32, 'on' => 'api_register'],
            [['ryb_user_emailid', 'ryb_user_phoneno'], 'unique', 'on' => 'api_register'],
            [['ryb_user_emailid', 'ryb_user_phoneno'], 'unique', 'on' => 'api_register_social'],
            [['ryb_user_picture', 'ryb_user_addr_home', 'ryb_user_addr_work', 'ryb_user_type'], 'safe'],
            [
                [
                    'ryb_user_fullname', 'ryb_user_emailid', 'ryb_user_phoneno', 'ryb_user_password',
                    'ryb_user_picture', 'ryb_user_addr_home', 'ryb_user_addr_work', 'ryb_status_id', 'ryb_user_verify_status'
                ],
                'required', 'on' => 'web_register'
            ],
            [
                [
                    'ryb_user_fullname', 'ryb_user_emailid', 'ryb_user_phoneno',
                    'ryb_user_addr_home', 'ryb_user_addr_work', 'ryb_status_id', 'ryb_user_verify_status'
                ],
                'required', 'on' => 'web_update'
            ],
            [['ryb_user_emailid', 'ryb_user_phoneno'], 'unique', 'on' => 'web_register, web_update'],
            //[[''], 'safe', 'on' => 'api_register'],
            [['ryb_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => StatusMaster::className(), 'targetAttribute' => ['ryb_status_id' => 'ryb_status_id']],
        ];
    }

    public function attributeLabels() {
        return [
            'ryb_user_id' => 'User ID',
            'ryb_status_id' => 'Status',
            'ryb_user_login_method' => 'Login method',
            'ryb_user_fullname' => 'Full name',
            'ryb_user_emailid' => 'Email id',
            'ryb_user_phoneno' => 'Phone no',
            'ryb_user_password' => 'Password',
            'ryb_user_picture' => 'Picture',
            'ryb_user_addr_work' => 'Work address',
            'ryb_user_addr_home' => 'Home address',
            'ryb_user_verify_status' => 'Verification Status',
            'ryb_user_verify_code' => 'Verify Code',
            'ryb_user_addedat' => 'Added at',
        ];
    }

    public function getAttributePlaceholder($attribute = '') {
        return strtolower($this->getAttributeLabel($attribute));
    }

    public function getUserEmerContMasters() {
        return $this->hasMany(UserEmerContMaster::className(), ['ryb_user_id' => 'ryb_user_id']);
    }

    public function getRybStatus() {
        return $this->hasOne(StatusMaster::className(), ['ryb_status_id' => 'ryb_status_id']);
    }

    public function getRybDriver()
    {
        return $this->hasOne(DriverMaster::className(), ['ryb_user_id' => 'ryb_user_id']);
    }

}
