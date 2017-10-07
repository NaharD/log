<?php

namespace nahard\log\helpers;

class Log
{
    /**
     * Returns log types.
     * @return array
     */
    public static function getTypes()
    {
        return [
            1 => 'error',
            2 => 'warning',
            4 => 'info',
        ];
    }

    /**
     * Calls for error log.
     * @param mixed $msg Message
     * @param string $var Model
     * @param string $category
     */
    public static function error($msg, $var = null, $category = 'application')
    {
        Yii::error([
            'msg'   => $msg,
            'var' => $var,
        ], $category);
		return false;
    }

    /**
     * Calls for info log.
     * @param mixed $msg Message
     * @param string $var Model
     * @param string $category
     */
    public static function info($msg, $var = null, $category = 'application')
    {
        Yii::info([
            'msg'   => $msg,
            'var' => $var,
        ], $category);
    }

    /**
     * Calls for warning log.
     * @param mixed $msg Message
     * @param string $var Model
     * @param string $category
     */
    public static function warning($msg, $var = null, $category = 'application')
    {
        Yii::warning([
            'msg'   => $msg,
            'var' => $var,
        ], $category);
    }
}
