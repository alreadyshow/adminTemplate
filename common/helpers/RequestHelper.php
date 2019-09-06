<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/3
 * Time: 18:01
 */

namespace common\helpers;

use Yii;

/**
 * 处理请求有关的处理类
 * Class RequestHelper
 * @author eddie 1021683438@qq.com
 * @package common\helpers
 */
class RequestHelper
{
    /**
     * get 方式获取数据
     * @author eddie 1021683438@qq.com
     * @param $requestUrl
     * @return mixed
     */
    public static function requestGet($requestUrl)
    {
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        Yii::info('访问地址: '.$requestUrl."\n 返回结果: ".$output, 'request');
        return $output;
    }

    /**
     * post 方式请求数据
     * @author eddie    1021683438@qq.com
     * @param $requestUrl
     * @param $data
     * @param bool $isHttps
     * @return mixed
     */
    public static function requestPost($requestUrl, $data, $isHttps = false)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        if($isHttps) {
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        }
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $output = curl_exec($ch);
        Yii::info('访问地址: '.urldecode($requestUrl)."\n 参数:".var_export($data) ."\n 返回结果: ".$output, 'request');
        curl_close($ch);

        return $output;
    }

    public static function sendFiles($url, $filename, $path, $type)
    {
        if (class_exists('\CURLFile')) {
            $data = array('file' => new \CURLFile(realpath($path), $type, $filename), 'name' => $filename);
        } else {
            $data = array(
                'file' => '@' . realpath($path) . ";type=" . $type . ";filename=" . $filename
            );
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $return_data = curl_exec($ch);
        curl_close($ch);
        return $return_data;
    }

    public static function sendStreamFile($url, $file)
    {

        if (file_exists($file)) {
            Yii::info('请求地址'.$url,'request');
            $opts = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'content-type:application/x-www-form-urlencoded',
                    'content' => file_get_contents($file)
                )
            );

            $context = stream_context_create($opts);
            $response = file_get_contents($url, false, $context);
            Yii::info($response,'request');
            return $response;

        } else {
            return false;
        }
    }
}