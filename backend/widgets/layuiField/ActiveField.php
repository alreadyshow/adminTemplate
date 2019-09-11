<?php
/**
 * Created by PhpStorm.
 * User: xuguoliang
 * Date: 2018/11/8
 * Time: 12:27
 */

namespace backend\widgets\layuiField;

use backend\widgets\layuiForm\ActiveForm;
use common\helpers\HtmlHelper;
use yii\helpers\Html;
use yii\web\JsExpression;

class ActiveField extends \yii\widgets\ActiveField
{

    public $inputOptions = ['class' => 'layui-input'];

    /**
     * @var string the template that is used to arrange the label, the input field, the error message and the hint text.
     * The following tokens will be replaced when [[render()]] is called: `{label}`, `{input}`, `{error}` and `{hint}`.
     */
    public $template = "{label}\n<div class=\"layui-input-inline\">{input}</div>\n{hint}\n{error}";

    /**
     * @var array the default options for the label tags. The parameter passed to [[label()]] will be
     * merged with this property when rendering the label tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $labelOptions = ['class' => 'layui-form-label'];

    /**
     * @var array the default options for the error tags. The parameter passed to [[error()]] will be
     * merged with this property when rendering the error tag.
     * The following special options are recognized:
     *
     * - `tag`: the tag name of the container element. Defaults to `div`. Setting it to `false` will not render a container tag.
     *   See also [[\yii\helpers\Html::tag()]].
     * - `encode`: whether to encode the error output. Defaults to `true`.
     *
     * If you set a custom `id` for the error element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $errorOptions = ['class' => 'layui-form-mid err-block'];

    /**
     * @var bool adds aria HTML attributes `aria-required` and `aria-invalid` for inputs
     * @since 2.0.11
     */
    public $addAriaAttributes = true;


    /**
     * Generates a tag that contains the first validation error of [[attribute]].
     * Note that even if there is no validation error, this method will still return an empty error tag.
     * @param array|false $options the tag options in terms of name-value pairs. It will be merged with [[errorOptions]].
     * The options will be rendered as the attributes of the resulting tag. The values will be HTML-encoded
     * using [[Html::encode()]]. If this parameter is `false`, no error tag will be rendered.
     *
     * The following options are specially handled:
     *
     * - `tag`: this specifies the tag name. If not set, `div` will be used.
     *   See also [[\yii\helpers\Html::tag()]].
     *
     * If you set a custom `id` for the error element, you may need to adjust the [[$selectors]] accordingly.
     * @see $errorOptions
     * @return $this the field object itself.
     */
    public function error($options = [])
    {
        if ($options === false) {
            $this->parts['{error}'] = '';
            return $this;
        }
        $options = array_merge($this->errorOptions, $options);
        $this->parts['{error}'] = Html::error($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * Renders a list of checkboxes.
     * A checkbox list allows multiple selection, like [[listBox()]].
     * As a result, the corresponding submitted value is an array.
     * The selection of the checkbox list is taken from the value of the model attribute.
     * @param array $items the data item used to generate the checkboxes.
     * The array values are the labels, while the array keys are the corresponding checkbox values.
     * @param array $options options (name => config) for the checkbox list.
     * For the list of available options please refer to the `$options` parameter of [[\yii\helpers\Html::activeCheckboxList()]].
     * @return $this the field object itself.
     */
    public function checkboxList($items, $options = [])
    {
        $this->template = "{label}\n<div class=\"layui-input-block\">{input}</div>\n{hint}\n{error}";

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = HtmlHelper::activeCheckboxList($this->model, $this->attribute, $items, $options);

        return $this;
    }

    /**
     * Renders a text area.
     * The model attribute value will be used as the content in the textarea.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     *
     * If you set a custom `id` for the textarea element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @return $this the field object itself.
     */
    public function textarea($options = ['class' => 'layui-textarea'])
    {
        $options = array_merge($this->inputOptions, $options);

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextarea($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * @param array $items
     * @param array $options
     * @param bool $search 是否开启搜索选择 默认：关闭
     * @return $this
     */
    public function dropDownList($items, $options = [], $search = false)
    {
        $options = array_merge($this->inputOptions, $options);
        if ($search) $options = array_merge($options, ['lay-search' => true]);
        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);

        return $this;
    }


    /**
     * @param $items
     * @param array $options
     * @return $this
     */
    public function multipleDropDownList($items, $options = [])
    {
        $options = array_merge($this->inputOptions, $options, [
            "xm-select-search" => true,
            "xm-select-search-type" => 'dl',
            'xm-select-height' => '36px'
        ]);

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);

        return $this;
    }

    /**
     * Renders a text input.
     * This method will generate the `name` and `value` tag attributes automatically for the model attribute
     * unless they are explicitly specified in `$options`.
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[Html::encode()]].
     *
     * The following special options are recognized:
     *
     * - `maxlength`: int|bool, when `maxlength` is set `true` and the model attribute is validated
     *   by a string validator, the `maxlength` option will take the value of [[\yii\validators\StringValidator::max]].
     *   This is available since version 2.0.3.
     *
     * Note that if you set a custom `id` for the input element, you may need to adjust the value of [[selectors]] accordingly.
     *
     * @return $this the field object itself.
     */
    public function dateInput($options = [], $conf = [])
    {
        $options = array_merge($this->inputOptions, $options);

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);

        $id = $this->getInputId();
        $str = '';
        if ($conf) {
            /**
             * @document https://www.layui.com/doc/modules/laydate.html
             */
            $keyWords = ['type', 'range', 'format', 'value', 'isInitValue', 'min', 'max', 'trigger', 'show', 'position', 'zIndex', 'showBottom', 'btns', 'lang', 'theme', 'calendar', 'mark'];

            foreach ($conf as $key => $item) {
                if (!in_array($key, $keyWords)) continue;
                if (in_array($key, ['btns', 'mark'])) {
                    if (!is_array($item)) continue;
                    $str .= ",{$key}: [";
                    foreach ($item as $value) {
                        $str .= "'{$value}',";
                    }
                    $str = rtrim($str, ',');
                    $str .= "]";
                } else {
                    $str .= ",{$key}: '{$item}'";
                }
            }
        }
        $js = <<<JS
var laydate = layui.laydate;

//日期
  laydate.render({
    elem: '#{$id}'
    {$str}
  });
JS;

        $this->form->layuiJs = new JsExpression($js);
        return $this;
    }


    /**
     * Renders a radio button.
     * This method will generate the `checked` tag attribute according to the model attribute value.
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - `uncheck`: string, the value associated with the uncheck state of the radio button. If not set,
     *   it will take the default value `0`. This method will render a hidden input so that if the radio button
     *   is not checked and is submitted, the value of this attribute will still be submitted to the server
     *   via the hidden input. If you do not want any hidden input, you should explicitly set this option as `null`.
     * - `label`: string, a label displayed next to the radio button. It will NOT be HTML-encoded. Therefore you can pass
     *   in HTML code such as an image tag. If this is coming from end users, you should [[Html::encode()|encode]] it to prevent XSS attacks.
     *   When this option is specified, the radio button will be enclosed by a label tag. If you do not want any label, you should
     *   explicitly set this option as `null`.
     * - `labelOptions`: array, the HTML attributes for the label tag. This is only used when the `label` option is specified.
     *
     * The rest of the options will be rendered as the attributes of the resulting tag. The values will
     * be HTML-encoded using [[Html::encode()]]. If a value is `null`, the corresponding attribute will not be rendered.
     *
     * If you set a custom `id` for the input element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @param bool $enclosedByLabel whether to enclose the radio within the label.
     * If `true`, the method will still use [[template]] to layout the radio button and the error message
     * except that the radio is enclosed by the label tag.
     * @return $this the field object itself.
     */
    public function radio($options = [], $enclosedByLabel = true)
    {
        if ($enclosedByLabel) {
            $this->parts['{input}'] = HtmlHelper::activeRadio($this->model, $this->attribute, $options);
            $this->parts['{label}'] = '';
        } else {
            if (isset($options['label']) && !isset($this->parts['{label}'])) {
                $this->parts['{label}'] = $options['label'];
                if (!empty($options['labelOptions'])) {
                    $this->labelOptions = $options['labelOptions'];
                }
            }
            unset($options['labelOptions']);
            $options['label'] = null;
            $this->parts['{input}'] = HtmlHelper::activeRadio($this->model, $this->attribute, $options);
        }

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        return $this;
    }

    /**
     * Renders a list of radio buttons.
     * A radio button list is like a checkbox list, except that it only allows single selection.
     * The selection of the radio buttons is taken from the value of the model attribute.
     * @param array $items the data item used to generate the radio buttons.
     * The array values are the labels, while the array keys are the corresponding radio values.
     * @param array $options options (name => config) for the radio button list.
     * For the list of available options please refer to the `$options` parameter of [[\yii\helpers\Html::activeRadioList()]].
     * @return $this the field object itself.
     */
    public function radioList($items, $options = [])
    {
        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }
        $this->template = "{label}\n<div class=\"layui-input-block\">{input}</div>\n{hint}\n{error}";
        $this->addRoleAttributes($options, 'radiogroup');
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = HtmlHelper::activeRadioList($this->model, $this->attribute, $items, $options);

        return $this;
    }

    /**
     * Renders a radio button.
     * This method will generate the `checked` tag attribute according to the model attribute value.
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - `uncheck`: string, the value associated with the uncheck state of the radio button. If not set,
     *   it will take the default value `0`. This method will render a hidden input so that if the radio button
     *   is not checked and is submitted, the value of this attribute will still be submitted to the server
     *   via the hidden input. If you do not want any hidden input, you should explicitly set this option as `null`.
     * - `label`: string, a label displayed next to the radio button. It will NOT be HTML-encoded. Therefore you can pass
     *   in HTML code such as an image tag. If this is coming from end users, you should [[Html::encode()|encode]] it to prevent XSS attacks.
     *   When this option is specified, the radio button will be enclosed by a label tag. If you do not want any label, you should
     *   explicitly set this option as `null`.
     * - `labelOptions`: array, the HTML attributes for the label tag. This is only used when the `label` option is specified.
     *
     * The rest of the options will be rendered as the attributes of the resulting tag. The values will
     * be HTML-encoded using [[Html::encode()]]. If a value is `null`, the corresponding attribute will not be rendered.
     *
     * If you set a custom `id` for the input element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @param bool $enclosedByLabel whether to enclose the radio within the label.
     * If `true`, the method will still use [[template]] to layout the radio button and the error message
     * except that the radio is enclosed by the label tag.
     * @return $this the field object itself.
     */
    public function switchInput($options = [], $enclosedByLabel = true)
    {
        if ($enclosedByLabel) {
            $this->parts['{input}'] = HtmlHelper::activeSwitch($this->model, $this->attribute, $options);
            $this->parts['{label}'] = '';
        } else {
            if (isset($options['label']) && !isset($this->parts['{label}'])) {
                $this->parts['{label}'] = $options['label'];
                if (!empty($options['labelOptions'])) {
                    $this->labelOptions = $options['labelOptions'];
                }
            }
            unset($options['labelOptions']);
            $options['label'] = null;
            $this->parts['{input}'] = HtmlHelper::activeRadio($this->model, $this->attribute, $options);
        }

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        return $this;
    }

    /**
     * Renders a checkbox.
     * This method will generate the `checked` tag attribute according to the model attribute value.
     * @param array $options the tag options in terms of name-value pairs. The following options are specially handled:
     *
     * - `uncheck`: string, the value associated with the uncheck state of the radio button. If not set,
     *   it will take the default value `0`. This method will render a hidden input so that if the radio button
     *   is not checked and is submitted, the value of this attribute will still be submitted to the server
     *   via the hidden input. If you do not want any hidden input, you should explicitly set this option as `null`.
     * - `label`: string, a label displayed next to the checkbox. It will NOT be HTML-encoded. Therefore you can pass
     *   in HTML code such as an image tag. If this is coming from end users, you should [[Html::encode()|encode]] it to prevent XSS attacks.
     *   When this option is specified, the checkbox will be enclosed by a label tag. If you do not want any label, you should
     *   explicitly set this option as `null`.
     * - `labelOptions`: array, the HTML attributes for the label tag. This is only used when the `label` option is specified.
     *
     * The rest of the options will be rendered as the attributes of the resulting tag. The values will
     * be HTML-encoded using [[Html::encode()]]. If a value is `null`, the corresponding attribute will not be rendered.
     *
     * If you set a custom `id` for the input element, you may need to adjust the [[$selectors]] accordingly.
     *
     * @param bool $enclosedByLabel whether to enclose the checkbox within the label.
     * If `true`, the method will still use [[template]] to layout the checkbox and the error message
     * except that the checkbox is enclosed by the label tag.
     * @return $this the field object itself.
     */
    public function checkbox($options = [], $enclosedByLabel = true)
    {
        if ($enclosedByLabel) {
            $this->parts['{input}'] = HtmlHelper::activeCheckbox($this->model, $this->attribute, $options);
            $this->parts['{label}'] = '';
            //var_dump($this->parts);die;
        } else {
            if (isset($options['label']) && !isset($this->parts['{label}'])) {
                $this->parts['{label}'] = $options['label'];
                if (!empty($options['labelOptions'])) {
                    $this->labelOptions = $options['labelOptions'];
                }
            }
            unset($options['labelOptions']);
            $options['label'] = null;
            $this->parts['{input}'] = HtmlHelper::activeCheckbox($this->model, $this->attribute, $options);
        }

        if ($this->form->validationStateOn === ActiveForm::VALIDATION_STATE_ON_INPUT) {
            $this->addErrorClassIfNeeded($options);
        }

        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        return $this;
    }


    /**
     * Adds aria attributes to the input options.
     * @param $options array input options
     * @since 2.0.11
     */
    protected function addAriaAttributes(&$options)
    {
        if ($this->addAriaAttributes) {
            if (!isset($options['required']) && $this->model->isAttributeRequired($this->attribute)) {
                $options['required'] = 'true';
                (isset($options['lay-verify'])) ? $options['lay-verify'] = "required|" . $options['lay-verify'] : $options['lay-verify'] = 'required';
            }
            if (!isset($options['invalid']) && $this->model->hasErrors($this->attribute)) {
                $options['invalid'] = 'true';
            }
        }
    }

    /**
     * Returns the JS options for the field.
     * @return array the JS options.
     */
    protected function getClientOptions()
    {
        return [];
    }
}
