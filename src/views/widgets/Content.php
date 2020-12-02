<?php

namespace wzzwx\yii2Inspinia\views\widgets;

use dmstr\widgets\Alert;

class Content extends Widget
{
    public $view = 'content';

    public function init()
    {
        parent::init();
        if (empty($this->replaceTags)) {
            $this->replaceTags = [
                'before_nav' => '',
                'alert' => Alert::widget(),
            ];
        }
    }

    public function runInternal()
    {
        return $this->render($this->view, \Yii::getObjectVars($this));
    }
}
