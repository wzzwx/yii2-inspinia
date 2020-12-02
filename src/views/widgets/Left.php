<?php

namespace wzzwx\yii2Inspinia\views\widgets;

class Left extends Widget
{
    public $view = 'left';

    public function init()
    {
        parent::init();
        if (empty($this->replaceTags)) {
            $this->replaceTags = [
                'search_form' => '',
                'dropdown' => '',
            ];
        }
    }

    public function runInternal()
    {
        return $this->render($this->view, \Yii::getObjectVars($this));
    }
}
