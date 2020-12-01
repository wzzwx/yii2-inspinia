<?php

use yii\helpers\Html;
use ethercap\watermark\WaterMark;
use wzzwx\yii2Inspinia\assets\InspiniaAsset;
use wzzwx\yii2Inspinia\views\widgets\Wrapper;

InspiniaAsset::register($this);

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $theme \wzzwx\yii2Inspinia\Theme */

$theme = $this->theme;
$assetPath = Yii::$app->assetManager->getBundle(InspiniaAsset::class)->baseUrl;
$content = $theme->contentRenderer($content);
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="<?= Yii::$app->charset; ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>
<?php
$this->beginBody();
if ($theme->watermark !== false) {
    WaterMark::widget(['alpha' => '0.05']);
}
$params = compact('assetPath', 'content');
echo Wrapper::widget($theme->buildWrapperConfig($params) + ['controllerCtx' => $this->context]);
$this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
