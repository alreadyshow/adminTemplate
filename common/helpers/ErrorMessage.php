<?php
/**
 * Created by PhpStorm.
 * User: Eddie
 * Date: 2019/6/20
 * Time: 10:13
 */

namespace common\helpers;

use Yii;

class ErrorMessage
{
    public static function set(string $info): void
    {
        Yii::$app->session->set("error_info", $info);
    }

    public static function get()
    {
        $msg = Yii::$app->session->get("error_info");
        Yii::$app->session->set("error_info", '');
        return $msg;
    }
}