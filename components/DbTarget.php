<?php

namespace nahard\log\components;

use yii\helpers\VarDumper;

class DbTarget extends \yii\log\DbTarget
{
    /**
     * Stores log messages to DB.
     */
    public function export()
    {
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp) = $message;
            $extracted = [
                'msg'   => '',
                'var' => null,
            ];
            if (is_array($text) && (isset($text['msg']) || isset($text['var']))) {
                if (isset($text['msg'])) {
                    if (!is_string($text['msg'])) {
                        $extracted['msg'] = VarDumper::export($text['msg']);
                    } else {
                        $extracted['msg'] = VarDumper::dumpAsString($text['msg'], 20, true);
                    }
                }
                if (isset($text['var'])) {
                    $extracted['var'] = $text['var'];
                }
            } elseif (is_string($text)) {
                $extracted['msg'] = $text;
            } else {
                $extracted['msg'] = VarDumper::export($text);
            }

            $logModel 			= new nahard\log\Log;
			$logModel->level    = $level;
			$logModel->category = $category;
			$logModel->message  = $extracted['msg'];
			$logModel->var		= $extracted['var'];
			$logModel->save();
        }
    }
}
