<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\helpers;

use common\models\LoginForm;
use Yii;


class GoogleCodeCheck extends \yii\base\ActionFilter
{

    /**
     * allow actions
     * @var array
     */
    public $actions = ['site/google-code', 'site/check-google-code', 'site/get-google-qr', 'site/logout'];

    /**
     * @inheritdoc
     */
    public function beforeAction($action){
        $actionId = $action->getUniqueId();
        if(Yii::$app->user->identity && !in_array($actionId , $this->actions)){
            //强制跳转设置google动态口令
            if(Yii::$app->user->identity->google_key == '') {
                Yii::$app->getResponse()->redirect(Yii::$app->urlManager->createUrl('site/google-code'));
                Yii::$app->end();
            }
            //是否验证过google 口令
            $isCheckGoogle = (bool)Yii::$app->session->get(LoginForm::CHECK_GOOGLE_SESS_KEY);
            if(!$isCheckGoogle) {
                Yii::$app->getResponse()->redirect(Yii::$app->urlManager->createUrl('site/check-google-code'));
                Yii::$app->end();
            }
        }
        return true;
    }
}
