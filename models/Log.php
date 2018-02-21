<?php

namespace nahard\log\models;

use Yii;
use yii\behaviors\TimestampBehavior;

class Log extends LogGii
{
	const STATUS_UNREAD = 0;
	const STATUS_READ = 1;
	const STATUS_LIST = [
		self::STATUS_UNREAD		=> 'Не прочитано',
		self::STATUS_READ		=> 'Прочитано',
	];
	
	public static function getStatusList($label=true)
	{
		return self::STATUS_LIST;
	}
	
	public static function getStatusLabel($statusId)
	{
		return self::STATUS_LIST[$statusId] ?? 'Невідомий';
	}

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

	static function getFreshLogMessages($limit=null)
	{
		return self::find()->statusUnread()->orderBy(['id'=>SORT_DESC])->limit($limit)->all();
	}

	public function makeReaded()
	{
		$this->status = self::STATUS_READ;
		return $this->save();
	}
	
	public function isReaded()
	{
		return $this->status == self::STATUS_READ;
	}
}
