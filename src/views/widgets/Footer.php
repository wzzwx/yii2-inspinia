<?php

namespace wzzwx\yii2Inspinia\views\widgets;

class Footer extends Widget
{
    public $view = 'footer';

    public function init()
    {
        parent::init();
        if (empty($this->replaceTags)) {
            $this->replaceTags = [
                'right' => '<b>Version</b> 2.0',
                'left' => '<strong>&copy;2018- '.date('Y').' callmewz 京ICP备19042689号-1</strong>',
            ];
        }
    }

    public function runInternal()
    {
        return $this->render($this->view, \Yii::getObjectVars($this));
    }
}
