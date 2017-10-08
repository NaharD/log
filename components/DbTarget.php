<?php

namespace nahard\log\components;

use Yii;
use yii\helpers\VarDumper;

class DbTarget extends \yii\log\DbTarget
{
    /**
     * Stores log messages to DB.
     */
    public function export()
    {
        foreach ($this->messages as $message) {
            list($text, $level, $category) = $message;
            $extracted = [
                'msg'   => '',
                'var' => null,
            ];
            if (is_array($text) && (isset($text['msg']) || isset($text['var']))) {
                if (isset($text['msg'])) {
                    if (!is_string($text['msg'])) {
                        $extracted['msg'] = VarDumper::export($text['msg']);
                    } else {
                        $extracted['msg'] = $text['msg'];
                    }
                }
                if (isset($text['var'])) {
                	if (is_array($text['var']))
                    	$extracted['var'] = VarDumper::export($text['var']);
                	elseif (is_object($text['var']))
						$extracted['var'] = json_encode($text['var'], JSON_PRETTY_PRINT);
                	else
						$extracted['var'] = $text['var'];
                }
            } elseif (is_string($text)) {
                $extracted['msg'] = $text;
            } else {
                $extracted['msg'] = VarDumper::export($text);
            }

			$logModel 				= new \nahard\log\models\Log;
			$logModel->level    	= $level;
			$logModel->category 	= $category;
			$logModel->message  	= $extracted['msg'];
			$logModel->var			= $extracted['var'];
			$logModel->request_url 	= Yii::$app->getRequest()->getAbsoluteUrl();
			$logModel->referrer_url = Yii::$app->getRequest()->getReferrer();
			$logModel->ip       	= Yii::$app->getRequest()->getUserIP();
			$logModel->user_id 		= Yii::$app->user->id ?? null;
			$logModel->save();
        }
    }
}
