<?php

namespace common\helpers;

use yii\db\Connection;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: Eddie
 * Date: 2018/11/21
 * Time: 11:44
 */
class CsvExportHelper
{
    /**
     * 导出CSV文件
     * @param array $data 数据
     * @param array $header_data 首行数据
     * @param string $file_name 文件名称
     * @return string
     */
    public static function export($data = [], $header_data = [], $file_name = '')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $file_name);
        header('Cache-Control: max-age=0');
        $fp = fopen('php://output', 'a');
        if (!empty($header_data)) {
            foreach ($header_data as $key => $value) {
                $header_data[$key] = iconv('utf-8', 'GBK//IGNORE', $value);
            }
            fputcsv($fp, $header_data);
        }
        $num = 0;
        //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 100000;
        //逐行取出数据，不浪费内存
        $count = count($data);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $num++;
                //刷新一下输出buffer，防止由于数据过多造成问题
                if ($limit == $num) {
                    ob_flush();
                    flush();
                    $num = 0;
                }
                $row = $data[$i];
                foreach ($row as $key => $value) {
                    $row[$key] = iconv('utf-8', 'GBK//IGNORE', $value);
                }
                fputcsv($fp, $row);
            }
        }
        fclose($fp);
    }

    /**
     * @modify non 2019/3/1 11:09
     * [[import] ]
     * @param Connection $db
     * @param $fileTmpName
     * @param $tableName
     * @param $importColumns
     * @return int
     * @throws \yii\db\Exception
     */
    public static function import(Connection $db, $fileTmpName, $tableName, $importColumns)
    {
        $filename = $fileTmpName;

        if (empty ($filename)) {
            return '请选择要导入的CSV文件！';
        }

        $handle = fopen($filename, 'r');
        $result = self::input_csv($handle); //解析csv

        $len_result = count($result);
        if ($len_result == 0) {
            return '没有任何数据！';
        }
        // 转化中文字符 并转换成字段名
        $newColmuns = array_combine(array_values($importColumns), array_keys($importColumns));
        foreach ($result[0] as &$value) {
            $value = iconv('gb2312', 'utf-8', $value);
            if (!isset($newColmuns[$value])) return $value . '该字段不存在！';
            $value = $newColmuns[$value];
        }
        unset($value);

        // 查询数据库表字段是否完整
        $sql = "select DISTINCT COLUMN_NAME from information_schema.columns where table_name='{$tableName}';";
        $columns = $db->createCommand($sql)->queryAll();

        $diff = array_diff($result[0], array_column($columns, 'COLUMN_NAME'));

        if ($diff) {
            return implode(',', $diff) . ' 该字段数据库中不存在！';
        }

        $data_values = '';
        $attribute = '';
        foreach ($result[0] as $value) {
            $attribute .= $value . ',';
        }
        $attribute = substr($attribute, 0, -1); // 去掉最后一个逗号
        $sql = "insert into {$tableName} ($attribute)"; // 动态获取插入字段

        unset($result[0]);
        foreach ($result as $value) {
            $values = '';
            foreach ($value as $item) {
                $item = iconv('gb2312', 'utf-8', $item);
                if (is_string($item)) $item = "'$item'"; //如果是字符串转换成携带引号
                $values .= "$item,";
            }
            $values = substr($values, 0, -1);
            $data_values .= "($values),";
        }
        $data_values = substr($data_values, 0, -1);
        $sql .= " values $data_values;";

        fclose($handle); //关闭指针
        return $sql;
    }

    public static function input_csv($handle)
    {
        $out = array();
        $n = 0;
        while ($data = fgetcsv($handle, 10000)) {
            $num = count($data);
            for ($i = 0; $i < $num; $i++) {
                $out[$n][$i] = $data[$i];
            }
            $n++;
        }
        return $out;
    }

    public static function export_csv($filename, $data)
    {
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $data;
    }

    /**
     * 大数据导出
     * @Time 2019/5/6 19:18
     * @param $count int 行数
     * @param Query $query
     * @param $head array 头
     * @param $fileName string 文件名
     * @param array $ext
     * @param null $column
     */
    public static function exportBigFile(int $count, Query $query, array $head, string $fileName, array $ext = [], $column = null)
    {
        set_time_limit(0);
        error_reporting(E_ERROR | E_PARSE);
        if (!empty($head)) {
            foreach ($head as $key => $value) {
                $head[$key] = iconv('utf-8', 'GBK//IGNORE', $value);
            }
        }

        $sqlLimit = 50000;

        $limit = 50000;

        $cnt = 0;
        $fileNameArr = array();
        $temp = \Yii::$app->runtimePath . '/' . $fileName;

        $times = ceil($count / $sqlLimit);
        for ($i = 0; $i < $times; $i++) {
            $fp = fopen($temp . '_' . $i . '.csv', 'w');

            $fileNameArr[] = $temp . '_' . $i . '.csv';

            fputcsv($fp, $head);
            $dataArr = $query->offset($i * $sqlLimit)
                ->limit($sqlLimit)
                ->asArray()
                ->all();
            foreach ($dataArr as $row) {
                $cnt++;
                if ($limit == $cnt) {
                    ob_flush();
                    flush();
                    $cnt = 0;
                }

                foreach ($row as $key => $value) {
                    $row[$key] = iconv('utf-8', 'GBK//IGNORE', $value);
                }
                fputcsv($fp, $row);
            }
            fclose($fp);
            unset($dataArr);
        }
        //进行多个文件压缩
        $zip = new \ZipArchive();
        $filename = \Yii::getAlias('@backend') . '/web/assets/' . $fileName . ".zip";
        $zip->open($filename, \ZipArchive::CREATE);   //打开压缩包
        foreach ($fileNameArr as $file) {
            $zip->addFile($file, basename($file));   //向压缩包中添加文件
        }
        $zip->close();  //关闭压缩包
        foreach ($fileNameArr as $file) {
            unlink($file); //删除csv临时文件
        }
    }
}