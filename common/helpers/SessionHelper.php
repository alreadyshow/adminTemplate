<?php
namespace common\helpers;
use Yii;
/**
 * session 帮助类
 * @Date: 2017/8/22
 * @Time: 16:17
 * @author eddie
 * @email 1021683438@qq.com
 * 解决原本session的过期时间问题
 */

class SessionHelper
{
    protected  $_session;

    /**
     * 默认过期时间 60s
     */
    const EXIST = 60;

    public function __construct()
    {
        $this->_session = Yii::$app->session;
    }

    /**
     * 判断是否已经过期
     * @param $key
     * @return bool
     */
    public function isOut($key)
    {
        if($this->_session->get($key) && $this->_session->get($key)['expire_time']) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 设置session 的方法
     * @param $key $key 设置session的键
     * @param $info $info 设置session的值
     * @param int $expire_time 设置session的过期时间
     */
    public  function setSession($key, $info, $expire_time = self::EXIST)
    {

        $data = [
            'data' => $info,
            'expire_time' => time() + $expire_time,
        ];

        $this->_session->set($key, $data);
    }

    /**
     * 获取session
     * @param $key
     * @return mixed
     */
    public function getSession($key)
    {
        $data = $this->_session->get($key);
        $time = time();
        if(isset($data['expire_time']) && $data['expire_time'] < $time) {
            return false;
        } else {
            return $data['data'];
        }
    }
}