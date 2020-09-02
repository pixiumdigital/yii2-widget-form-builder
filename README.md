# yii2-widget-form-builder
Wrapper around the Pixium Form Builder

# Installation

The preferred way to install this extension is through [Composer](https://getcomposer.org).

add

```
    "repositories": [
        ...
        {
            "type": "vcs",
            "url": "https://github.com/pixiumdigital/yii2-widget-form-builder"
        }
        ...
    ]
```

and add to require list

```
        "pixium/yii2-widget-form-builder": "dev-master",
```

# Usage

```php
use pixium\widgets\FromBuilder;

FormBuilder::widget([
    'div' => 'container',
    'data' => data, //JSON
    'mode' => 'run' //or 'build'
]); 
```

or 

```php
use pixium\widgets\FromBuilder;

$form->field($model, 'data')->widget(
        FormBuilder::class,
        [
            'div' => 'container',
            'data' => data, //JSON
            'mode' => 'run' //or 'build'
        ]
    );

```
