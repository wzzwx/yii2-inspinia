<?php

namespace wzzwx\yii2Inspinia\views\widgets;

class Header extends Widget
{
    public $view = 'header';

    public function init()
    {
        parent::init();
        if (empty($this->replaceTags)) {
            $this->replaceTags = [
                'nav_left' => '',
                'nav_right' => '<ul class="nav navbar-top-links navbar-right"><li>
                    <a href="/site/logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li></ul>',
            ];
        }
    }

    public function runInternal()
    {
        return $this->render($this->view, \Yii::getObjectVars($this));
    }
}
