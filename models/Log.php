<?php

namespace nahard\log\models;

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

			// code

			return true;
		}
		return false;
	}

	static function getFreshLogCount()
	{
		return self::find()->statusUnread()->count();
	}
	
	static function getFreshLogCountWidget()
	{
		if ($count =  self::find()->statusUnread()->count())
			return "<small class=\"label pull-right bg-green\">{$count}</small></span>";
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
