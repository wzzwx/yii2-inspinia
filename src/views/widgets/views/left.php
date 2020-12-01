<?php

namespace wzzwx\yii2Inspinia;

use Yii;
use yii\helpers\ArrayHelper;

/* @var $theme \wzzwx\yii2Inspinia\Theme */
/** @var $assetPath */
$user = $theme->user;
$logo = $assetPath.'/img/logo.jpg';
if ($user && isset($user->avatar) && !empty($user->avatar)) {
    $logo = $user->avatar;
}

?>
<nav class="navbar-default navbar-static-side" role='navigation'>
    <div class="sidebar-collapse">
        <div class="nav-header">
            <div class="dropdown profile-element">
                <span><img alt="image" class="img-circle img-md" src="<?= $logo; ?>"></span>
                <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
                    <span class="block m-t-xs">
                        <?= $user ? $user->name : '游客'; ?>  <b class="caret"></b>
                    </span>
                </a>
                {dropdown}
            </div>
        </div>
        {search_form}
        <div class="logo-element">
            <span><img alt="image" class="img-circle img-sm" src="<?= $logo; ?>"></span>
        </div>
        <?php
        if ($userId = ArrayHelper::getValue(Yii::$app, 'user.id')) {
            echo widgets\Menu::widget([
                'items' => $theme->parseMenuItems(),
                'options' => ['class' => 'nav metismenu', 'id' => 'side-menu'],
                'submenuTemplate' => "\n<ul class='nav nav-fourth-level' {show}>\n{items}\n</ul>\n",
                'tplMap' => [
                    "\n<ul class='nav nav-second-level' {show}>\n{items}\n</ul>\n",
                    "\n<ul class='nav nav-third-level' {show}>\n{items}\n</ul>\n",
                    "\n<ul class='nav nav-fourth-level' {show}>\n{items}\n</ul>\n",
                ],
            ]);
        }
        ?>
    </div>
</nav>
