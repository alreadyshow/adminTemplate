<?php
namespace common\helpers;


use backend\models\Agent;

class DbHelper
{
    public static function getParentList ( $rootId )
    {
        \Yii::info('-v24');
        $p_info =  Agent::find()
            ->where(['userid'=>$rootId])
            ->select('pid,lv')
            ->one();
        if ( $p_info['pid'] == 0 ) {
            if ( $p_info['lv'] == 1 ) {
                $pppid = $rootId;
            } else {
                $pppid = 0;
            }
        } else {
            $pppid = self::getParentList($p_info['pid']);
        }
        return $pppid;
    }
}