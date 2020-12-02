<?php

namespace wzzwx\yii2Inspinia\views\widgets;

use Yii;
use yii\base\Widget as BaseWidget;
use yii\base\InvalidCallException;

class Widget extends BaseWidget
{
    public $theme;
    public $content;
    public $assetPath;
    public $controllerCtx;

    public $extraView = [];
    public $replaceTags = [];

    protected $detail;

    public function init()
    {
        parent::init();
        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        parent::run();
        $this->detail = ob_get_clean();
        return $this->applyExtraView($this->runInternal());
    }

    protected function applyExtraView($tpl)
    {
        $replaceList = $this->extraView + $this->replaceTags;
        if (!$replaceList) {
            return $tpl;
        }
        $replace = [];
        foreach ($replaceList as $key => $view) {
            $replace["{{$key}}"] = strpos($view, '@') === 0 || strpos($view, '/') === 0 ? $this->render($view, Yii::getObjectVars($this)) : $view;
        }
        return strtr($tpl, $replace);
    }

    protected function runInternal()
    {
        throw new InvalidCallException();
    }

    public function comCfg()
    {
        return [
            'theme' => $this->theme,
            'content' => $this->content,
            'assetPath' => $this->assetPath,
            'controllerCtx' => $this->controllerCtx,
        ];
    }
}
