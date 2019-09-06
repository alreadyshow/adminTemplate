<?php
/**
 * Created by PhpStorm.
 * User: Eddie
 * Date: 2019/5/10
 * Time: 11:40
 */

namespace common\helpers;


use common\models\GmConfig;
use Yii;

class GameServer extends RequestHelper
{
    const REQUEST_SUCCESS = true;

    const REQUEST_FAILED = false;

    /**
     * 与服务器通信的公用方法
     * @Time 2019/5/10 14:02
     * @param $apiName
     * @param $data
     * @return int|array
     */
    public static function api($apiName, $data)
    {
        $config = GmConfig::params();
        if (!isset($config[$apiName])) {
            Yii::$app->session->setFlash('error', '没有配置' . $apiName . '接口,请配置');
            return self::REQUEST_FAILED;
        }

        $encode = urlencode(json_encode($data, true));

        $url = $config['game_server_address'] . $config[$apiName] . $encode;

        try {
            $res = parent::requestGet($url, 25);
            $result = json_decode($res, true);
            return $result;
        } catch (\Exception $e) {
            Yii::error($e);
            return self::REQUEST_FAILED;
        }
    }
}