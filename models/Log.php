<?php

namespace nahard\log\models;

use Yii;
use yii\behaviors\TimestampBehavior;

class Log extends LogGii
{
	const STATUS_UNREAD = 0;
	const STATUS_READ = 1;

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {

			$this->user_id 		= Yii::$app->user->id ?? null;
			$this->referrer_url = Yii::$app->getRequest()->getReferrer() ?? null;
			$this->request_url 	= Yii::$app->getRequest()->getUrl() ?? null;
			$this->ip       	= Yii::$app->getRequest()->getUserIP() ?? null;

			return true;
		}
		return false;
	}

	static function getFreshLogCount()
	{
		return self::find()->statusUnread()->count();
	}

	static function getFreshLogMessages()
	{
		return self::find()->statusUnread()->orderBy(['id'=>SORT_DESC])->all();
	}

	public function makeReaded()
	{
		$this->status = self::STATUS_READ;
		return $this->save();
	}
}
