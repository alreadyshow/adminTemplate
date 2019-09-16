<?php
/**
 * Created by PhpStorm.
 * User: non
 * Date: 2019/09/16 0016
 * Time: 10:58
 */

namespace backend\widgets\layuiGridView;

/**
 * Class ActionColumn
 * @package backend\widgets\layuiGridView
 * @property $filter string
 * @property $title string
 * @property $template string
 * @property $visible bool
 * @property $buttons array
 * @property $clientScript string
 * @property $toolbarTemplate string
 */
class ActionColumn extends BaseColumn
{
    /**
     * @var string layui 容器属性
     */
    public $filter;

    /**
     * @var string 操作列表头
     */
    public $title;

    /**
     * @var
     */
    public $template = "{edit} {delete}";

    /**
     * @var bool 是否展示 默认：展示.
     */
    public $visible = true;

    /**
     * @var array 按钮配置
     */
    public $buttons;

    /**
     * @var string 客户端脚本
     */
    public $clientScript;

    /**
     * @var string 工具模板
     */
    public $toolbarTemplate;

    public function init()
    {
        parent::init();
        $this->clientScript = "
        var table = layui.table;
        table.on('tool({$this->filter})', function(obj){
            var data=obj.data;
        ";
        $this->initButtons();
        $this->endClientScript();
    }

    private function initButtons()
    {
        $this->checkButtons();
        $this->initToolbarTemplate();
        preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) {
            $name = $matches[1];
            if (isset($this->buttons[$name])) {
                $script = <<<SC
if(obj.event == '{$name}'){
{$this->buttons[$name]['script']}
}
SC;
                $this->clientScript .= $script;
                $this->toolbarTemplate .= $this->buttons[$name]['content'];
            }

            return '';
        }, $this->template);
    }

    private function checkButtons(){
        if (empty($this->buttons)) return true;
        foreach ($this->buttons as $button) {
            if (!isset($button['script'])) {
                throw new \Exception("没有客户端脚本");
            }
        }
        return true;
    }

    private function initToolbarTemplate()
    {
    }

    private function endClientScript()
    {
        $this->clientScript .= "});";
    }

}