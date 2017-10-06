<?php

namespace nahard\log\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $level
 * @property string $category
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $ip
 * @property string $message
 * @property string $var
 * @property string $referrer_url
 * @property string $request_url
 * @property integer $user_id
 * @property integer $status
 */
class LogGii extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'created_at', 'updated_at', 'user_id', 'status'], 'integer'],
            [['message', 'var', 'referrer_url', 'request_url'], 'string'],
            [['category', 'ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'category' => 'Category',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'ip' => 'Ip',
            'message' => 'Message',
            'var' => 'Var',
            'referrer_url' => 'Referrer Url',
            'request_url' => 'Request Url',
            'user_id' => 'User Id',
            'status' => 'Status',
        ];
    }

    /**
     * @inheritdoc
     * @return LogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogQuery(get_called_class());
    }
}
