<?php

namespace wzzwx\yii2Inspinia;

use Yii;
use yii\base\Theme as YiiTheme;
use yii\helpers\ArrayHelper;
use wzzwx\yii2Inspinia\views\widgets\Content;
use wzzwx\yii2Inspinia\views\widgets\Header;
use wzzwx\yii2Inspinia\views\widgets\Left;
use wzzwx\yii2Inspinia\views\widgets\Footer;

class Theme extends YiiTheme
{
    public $pathMap = [
        '@app/views' => '@vendor/wzzwx/yii2-inspinia/src/views',
    ];

    public $bathPath = 'src';
    public $content;
    public $nowrap;
    public $watermark;
    public $menuItems;

    public $left = [];
    public $header = [];
    public $footer = [];
    public $main = [];

    public $user;

    public function init()
    {
        parent::init();
        if (!Yii::$app->user->isGuest) {
            $this->user = Yii::$app->user->identity;
        }
    }

    public function parseMenuItems()
    {
        if ($this->menuItems instanceof \Closure) {
            return call_user_func($this->menuItems, $this, Yii::$app);
        }
        return $this->menuItems;
    }

    public function contentRenderer($content)
    {
        if ($this->content instanceof \Closure) {
            return call_user_func($this->content, $content, $this, Yii::$app);
        }
        return $content;
    }

    public function buildWrapperConfig($params)
    {
        return $params + [
                'theme' => $this,
                'noWrap' => $this->nowrap,
                'leftRender' => function ($widget) {
                    return $this->buildWidget($widget->theme->left, $widget, Left::class);
                },
                'headerRender' => function ($widget) {
                    return $this->buildWidget($widget->theme->header, $widget, Header::class);
                },
                'footerRender' => function ($widget) {
                    return $this->buildWidget($widget->theme->footer, $widget, Footer::class);
                },
                'contentRender' => function ($widget) {
                    return $this->buildWidget($widget->theme->main, $widget, Content::class);
                },
            ];
    }

    protected function buildWidget($config, $widget, $defaultClass)
    {
        if ($class = ArrayHelper::remove($config, 'class')) {
            return $class::widget($config);
        }
        return $defaultClass::widget($widget->comCfg() + $config);
    }
}
