## Inspinia Theme
### inspinia主题的上层封装。
    依赖包 https://github.com/lkk/yii2-inspinia。
    提供几乎全部inspinia会用到的静态资源的打包。
    如需用到Inspinia资源，请优先使用已经打包好的。

### 命名空间
    wzzwx\yii2Inspinia
### 使用方式
- App的main配置添加如下配置即可

```
'view' => [
    'theme' => [
        'class' => 'wzzwx\yii2Inspinia\Theme',
            'node' => 'dee',
            'nowrap' => !YII_DEBUG,
        ],
    ],
```
### 可用配置
- content  
匿名函数：function($content, $theme){};   
参数为layout重的content部分，和当前主题。   
e.g.:   

```
  'content' => function($content, $theme) {
      if ($theme->nowrap) {
          return "<div class=\"p-w-sm\">$content</div>";
      }
      return $content;
  },
                  
```

### 注意
- app->user 须有name属性，用于展示

### 更新：

- 已支持common包中的box样式。
