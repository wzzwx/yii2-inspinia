<?php

namespace wzzwx\yii2Inspinia\views\widgets;

class Footer extends Widget
{
    public $view = 'footer';

    public function init()
    {
        parent::init();
        $this->replaceTags = [
            'right' => '<b>Version</b> 2.0',
            'left' => '<strong>&copy;2014- '.date('Y').' 以太资本 京ICP备14028208号</strong>',
        ];
    }

    public function runInternal()
    {
        return $this->render($this->view, \Yii::getObjectVars($this));
    }
}
