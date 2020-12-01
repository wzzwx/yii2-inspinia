<?php

use yii\widgets\Breadcrumbs;

/* @var $theme \wzzwx\yii2Inspinia\Theme */
/* @var $controllerCtx \yii\web\Controller */

if (isset($this->blocks['content-header'])) {
    $title = $this->blocks['content-header'];
} else {
    if ($this->title !== null) {
        $title = \yii\helpers\Html::encode($this->title);
    } else {
        $title = \yii\helpers\Inflector::camel2words(
            \yii\helpers\Inflector::id2camel($controllerCtx->module->id)
        );
        $title .= ($controllerCtx->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
    }
}
?>
{before_nav}
<?php if (!empty($title)): ?>
    <div class="row wrapper border-bottom white-bg page-heading m-b">
        <div class="col-md-9">
            <h2><?= $title; ?></h2>
            <?= Breadcrumbs::widget(
                [
                    'activeItemTemplate' => "<li class=\"active\"><strong>{link}</strong></li>\n",
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]
            ); ?>
        </div>
    </div>
<?php endif; ?>
<div class="<?= $theme->nowrap ? 'content' : 'content-wrapper'; ?>">
    <section class="content">
        {alert}
        <?= $content; ?>
    </section>
</div>
