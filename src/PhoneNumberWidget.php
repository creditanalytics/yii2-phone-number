<?php

namespace creditanalytics\phonenumber;

use yii\base\Exception;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Suggestions Component
 */
class PhoneNumberWidget extends InputWidget
{
    public $id     = null;
    public $placeholder = false;
    public $region = 'RU';
    public $blocks;
    public $delimeter;

    public function init()
    {
        parent::init();

        $this->id = Html::getInputId($this->model, $this->attribute);

        if (!$this->id)
            throw new Exception('Не правильный конфиг');
    }

    public function run()
    {
        CleaveAsset::register($this->view);
        $value = Html::getAttributeValue($this->model, $this->attribute);
        $options = ArrayHelper::merge($this->options, $this->field->inputOptions, ['value' => $value]);

        $contents[] = Html::activeInput('text', $this->model, $this->$attribute, $options);

        $this->regJs();

        return implode("\n", $contents);
    }

    protected function regJs()
    {
        $this->view->registerJs(
            'var cleave__' . $this->id . 'new Cleave("#' . $this->id . '", {
                delimiter: ' . $this->delimiter . ',
                blocks: ' . $this->blocks . '
            });'
        );
    }
}
