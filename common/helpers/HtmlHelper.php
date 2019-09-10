<?php
/**
 * Created by PhpStorm.
 * User: non
 * Date: 2019/9/10
 * Time: 16:01
 */

namespace common\helpers;


use yii\helpers\BaseHtml;

class HtmlHelper extends BaseHtml
{
    public static function submitButton($content = 'Submit', $options = [])
    {
        $btn = parent::submitButton($content, array_merge($options, [
            'lay-submit' => true,
        ]));

        return parent::tag('div', $btn, ['class' => 'layui-input-block']);
    }

}