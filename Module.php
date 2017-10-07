<?php

namespace nahard\log;

use Yii;
use yii\base\InvalidParamException;

/**
 * manager module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'nahard\log\controllers';
    public $accessRules = [
		[
			'actions' => ['view'],
			'allow' => true,
			'roles' => ['logView'],
		],
		[
			'actions' => ['index'],
			'allow' => true,
			'roles' => ['logUpdate'],
		],
		[
			'actions' => ['update'],
			'allow' => true,
			'roles' => ['logUpdate'],
		],
		[
			'actions' => ['create'],
			'allow' => true,
			'roles' => ['logCreate'],
		],
		[
			'actions' => ['delete'],
			'allow' => true,
			'roles' => ['logDelete'],
		],
	];

    /**
     * @inheritdoc
     */
	public function init()
	{
		parent::init();

		// code
	}
}
