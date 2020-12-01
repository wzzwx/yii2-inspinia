<?php

namespace wzzwx\yii2Inspinia\widgets;

use Yii;
use yii\widgets\Menu as YiiMenu;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

class Menu extends YiiMenu
{
    public $options = ['class' => 'sidebar-menu', 'id' => 'sidebar-menu'];

    public $linkTemplate = '<a href="{url}">{icon} {label} {noticeLabel}</a>';
    public $submenuTemplate = "\n<ul class='treeview-menu' {show}>\n{items}\n</ul>\n";
    public $activateParents = true;
    public $defaultIconHtml = '';

    public $tplMap = [];

    /**
     * @var string
     */
    public static $iconClassPrefix = 'fa fa-';

    private $noDefaultAction;
    private $noDefaultRoute;

    public function run()
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
        $posDefaultAction = strpos($this->route, Yii::$app->controller->defaultAction);
        if ($posDefaultAction) {
            $this->noDefaultAction = rtrim(substr($this->route, 0, $posDefaultAction), '/');
        } else {
            $this->noDefaultAction = false;
        }
        $posDefaultRoute = strpos($this->route, Yii::$app->controller->module->defaultRoute);
        if ($posDefaultRoute) {
            $this->noDefaultRoute = rtrim(substr($this->route, 0, $posDefaultRoute), '/');
        } else {
            $this->noDefaultRoute = false;
        }
        $items = $this->normalizeItems($this->items, $hasActiveChild);
        if (!empty($items)) {
            $options = $this->options;
            $tag = ArrayHelper::remove($options, 'tag', 'ul');
            echo Html::tag($tag, $this->renderItems($items), $options);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function renderItem($item, $root = true)
    {
        $nested = false;
        if (isset($item['items'])) {
            $nested = true;
            $labelTemplate = '<a href="{url}">{icon} {label} <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>{noticeLabel}</a>';
            $linkTemplate = '<a href="{url}">{icon} {label} <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>{noticeLabel}</a>';
        } else {
            $labelTemplate = $this->labelTemplate;
            $linkTemplate = $this->linkTemplate;
        }

        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $linkTemplate);
            $replace = !empty($item['icon']) ?
                ['{url}' => Url::to($item['url']), '{icon}' => '<i class="'.self::$iconClassPrefix.$item['icon'].'"></i> '] :
                ['{url}' => Url::to($item['url']), '{icon}' => $this->defaultIconHtml];
        } else {
            $template = ArrayHelper::getValue($item, 'template', $labelTemplate);
            $replace = !empty($item['icon']) ?
                ['{icon}' => '<i class="'.self::$iconClassPrefix.$item['icon'].'"></i> '] :
                ['{icon}' => $this->defaultIconHtml];
        }

        $label = ['{label}' => $root ? Html::tag('span', $item['label']) : $item['label']];
        $noticeReplace = ['{noticeLabel}' => ''];
        if (isset($item['noticeLabel']) && $noticeLabel = trim($item['noticeLabel'])) {
            $pullRight = $nested ? '' : ' pull-right';
            $type = ArrayHelper::getValue($item, 'noticeType', 'warning');
            $noticeReplace = ['{noticeLabel}' => Html::tag('span', $noticeLabel, ['class' => 'label label-'.$type.$pullRight])];
        }

        return strtr($template, array_merge($replace, $noticeReplace, $label));
    }

    protected function renderItems($items, $root = true, $level = 0)
    {
        $n = count($items);
        $lines = [];
        $template = ArrayHelper::getValue($this->tplMap, $level, $this->submenuTemplate);
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }

            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }

            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }

            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' '.implode(' ', $class);
                }
            }
            (isset($item['node-key']) && !empty($item['node-key'])) && $options['id'] = $item['node-key'];
            $menu = $this->renderItem($item, $root);
            if (!empty($item['items'])) {
                $menu .= strtr($template, [
                    '{show}' => $item['active'] ? "style='display: block'" : '',
                    '{items}' => $this->renderItems($item['items'], false, $level + 1),
                ]);
            }

            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

    /**
     * {@inheritdoc}
     */
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $items[$i]['icon'] = isset($item['icon']) ? $item['icon'] : '';
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
        }
        return array_values($items);
    }

    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     *
     * @param array $item the menu item to be checked
     *
     * @return bool whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = ltrim(Yii::$app->controller->module->getUniqueId().'/'.$route, '/');
            }
            $route = ltrim($route, '/');
            if ($route != $this->route && $route !== $this->noDefaultRoute && $route !== $this->noDefaultAction) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                foreach (array_splice($item['url'], 1) as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
}
