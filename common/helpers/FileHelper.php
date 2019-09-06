<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/7/13
 * Time: 20:58
 */
namespace common\helpers;

use yii\base\ErrorException;

/**
 * 文件操作助手类
 * Class FileHelper
 * @package common\helpers
 */
class FileHelper extends \yii\helpers\FileHelper
{
    /**
     * 清除缓存静态方法
     * @param string $dir 目标文件夹
     * @param array $options
     * @throws ErrorException
     */
    public static function clearDirectory($dir, $options = []) {
        if (!is_dir($dir)) {
            return;
        }
        if (isset($options['traverseSymlinks']) && $options['traverseSymlinks'] || !is_link($dir)) {
            if (!($handle = opendir($dir))) {
                return;
            }
            while (($file = readdir($handle)) !== false) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                $path = $dir . DIRECTORY_SEPARATOR . $file;
                if (is_dir($path)) {
                    static::removeDirectory($path, $options);
                } else {
                    try {
                        unlink($path);
                    } catch (ErrorException $e) {
                        if (DIRECTORY_SEPARATOR === '\\') {
                            // last resort measure for Windows
                            $lines = [];
                            exec("DEL /F/Q \"$path\"", $lines, $deleteError);
                        } else {
                            throw $e;
                        }
                    }
                }
            }
            closedir($handle);
        }
    }

    /**
     * 日志
     * @param $info
     * @param $action
     */
    public static function setLog($info, $action)
    {
//        $fileName = '../runtime/logs/'.date('Y-m-d').'.log';
//        if(!is_dir('../runtime/logs')) {
//            chdir('../runtime');
//            mkdir('logs');
//        }
//        if(is_array($info)) {
//            $in = var_export($info, true) ;
//        } else {
//            $in = $info;
//        }
//        $data = date('Y-m-d H:i:s').' '.\Yii::$app->user->identity->username.' '.$in.' '.$action."\n";
//        if(file_exists($fileName)) {
//            $handel = fopen($fileName, 'a');
//            fwrite($handel, $data);
//            fclose($handel);
//        } else {
//            file_put_contents($fileName, $data);
//        }
    }

}