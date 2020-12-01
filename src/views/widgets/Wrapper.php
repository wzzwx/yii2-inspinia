<?php

namespace wzzwx\yii2Inspinia\views\widgets;

class Wrapper extends Widget
{
    public $noWrap;
    public $template;
    public $contentRender;
    public $headerRender;
    public $leftRender;
    public $footerRender;

    public $bg = 'gray-bg';

    protected $defaultTemplate;

    public function init()
    {
        parent::init();
        $bodyClass = empty($_COOKIE['inspinia_mini_navbar']) ? '' : ' class="mini-navbar"';
        if ($this->noWrap) {
            $this->defaultTemplate = <<<WRAPPER
<body class="{$this->bg}">
{content}
WRAPPER;
        } else {
            $this->defaultTemplate = <<<WRAPPER
<body{$bodyClass}>
<div id="wrapper">
    {left}
    <div id="page-wrapper" class="{$this->bg}">
        {header}
        {content}
        {footer}
    </div>
</div>
WRAPPER;
        }
    }

    protected function runInternal()
    {
        $this->template || $this->template = $this->defaultTemplate;
        $replace = $this->noWrap ?
            [
                '{content}' => $this->getContent($this->contentRender),
            ] : [
                '{content}' => $this->getContent($this->contentRender),
                '{header}' => $this->getContent($this->headerRender),
                '{left}' => $this->getContent($this->leftRender),
                '{footer}' => $this->getContent($this->footerRender),
            ];
        return strtr(
            $this->detail ?: $this->template,
            $replace
        );
    }

    public function getContent($render)
    {
        if ($render instanceof \Closure || is_callable($render)) {
            return call_user_func($render, $this);
        }
    }
}
