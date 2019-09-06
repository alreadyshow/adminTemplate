<?php
/**
 * Created by PhpStorm.
 * User: non
 * Date: 2019/5/28
 * Time: 17:17
 */

namespace common\helpers;


class DwzHelper
{
    // APPkey，我在网上找的（https://fengmk2.com/blog/appkey.html），可以自己申请
    protected $appKey; // = '31641035'
    // 转短连接API地址
    protected $shortUrl = 'https://api.weibo.com/2/short_url/shorten.json?';

    public function __construct($appKey)
    {
        $this->appKey = $appKey;
    }

    /**
     * 生成短链接
     * @param array $longUrl 长链接数组
     * @return array 返回短连接数据
     */
    public function getShortUrl($longUrl = [])
    {
        $code = true;
        $msg = '请求成功！';
        $result = [];
        // 长链接数组为空，不处理
        if (empty($longUrl)) {
            $code = false;
            $msg = '长链接数据不能为空';
            return ['code' => $code, 'msg' => $msg, 'result' => $result];
        }
        // 拼接请求URL
        $longUrlStr = $this->_getLongUrl($longUrl);
        $shortUrl = $this->shortUrl;
        $appKey = $this->appKey;
        $param = 'source=' . $appKey . '&' . $longUrlStr;
        $curlUrl = $shortUrl . $param;
        // 发送CURL请求
        $result = $this->_sendCurl($curlUrl);
        return ['code' => $code, 'msg' => $msg, 'result' => $result];
    }

    /**
     * 获取请求URL字符串
     * @param array $longUrl 长链接数组
     * @return string 长链接URL字符串
     */
    private function _getLongUrl($longUrl = [])
    {
        $str = '';
        foreach ($longUrl as $url) {
            $str .= ('url_long=' . $url . '&');
        }
        $newStr = substr($str, 0, strlen($str) - 1);
        return $newStr;
    }

    /**
     * 发送CURL请求（GET）
     * @param string $curlUrl 请求地址
     * @return array 返回信息
     */
    private function _sendCurl($curlUrl)
    {
        \Yii::info($curlUrl, '短网址请求地址');
        $output = file_get_contents($curlUrl);
        $result = json_decode($output, true);
        \Yii::info($result, '短网址请求结果');
        return $result;
    }
}