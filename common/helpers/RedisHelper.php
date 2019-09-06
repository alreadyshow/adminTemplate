<?php
namespace common\helpers;

use common\models\GmConfig;
use yii\redis\Connection;

class RedisHelper
{
    private $_connection;

    public function __construct()
    {
        if (!$this->_connection instanceof Connection) {
            // 获取redis配置
            $config = GmConfig::findOne(['cate' => 1, 'name' => 'redis']);
            $configRedis = json_decode($config->value);
            // 连接redis
            $redis           = new \yii\redis\Connection();
            $redis->hostname = $configRedis->ip;
            $redis->port     = $configRedis->port;
            if (!empty($configRedis->auth)) {
                $redis->password = $configRedis->auth;
            }
            $redis->open();
            $this->_connection = $redis;
        }
    }

    /**
     * [set 设置值]
     * @author jonni 2018-11-12
     * @param  [type]  $key    [key名]
     * @param  [type]  $value  [值]
     * @param  integer $expire [过期时间]
     * @return mixed
     */
    public function set($key, $value, $expire = 0)
    {
        $this->_connection->set($key, $value);
        if ($expire > 0) {
            $this->_connection->expire($key, $expire);
        }
        return $value;
    }

    /**
     * [get 获取值]
     * @author jonni 2018-11-12
     * @param  [type] $key [key名]
     * @return [type]      [description]
     */
    public function get($key)
    {
        return $this->_connection->get($key);
    }

    /**
     * [exists 判断key是否存在]
     * @author jonni 2018-11-12
     * @param  [type] $key [key名]
     * @return [type]      [description]
     */
    public function exists($key)
    {
        return $this->_connection->exists($key);
    }

    /**
     * [del 删除缓存]
     * @author jonni 2018-11-12
     * @param  [type] $key [key名]
     * @return [type]      [description]
     */
    public function del($key)
    {
        return $this->_connection->del($key);
    }

    /**
     * [incr 值增加1]
     * @author gm1 2019-03-15
     * @param  [type] $key [key名]
     * @return [type]      [description]
     */
    public function incr($key)
    {
        return $this->_connection->incr($key);
    }

    /**
     * [decrby 值做减法]
     * @author jonni 2018-11-12
     * @param  [type] $key [key名]
     * @param  [type] $dec [递减数目]
     * @return [type]      [description]
     */
    public function decrby($key, $dec)
    {
        return $this->_connection->decrby($key, (int) $dec);
    }
}
