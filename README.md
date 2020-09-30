## Form Builder

Wrapper around the Pixium Form Builder (Google Form like)

## Installation

The preferred way to install this extension is through [composer](https://getcomposer.org/download/)

add

```
$ composer require pixium/yii2-widget-form-builder:dev-master
```

or add

```
"pixium/yii2-widget-form-builder": "dev-master",
```

to the require section of your composer.json file.


## Usage

```php
use pixium\widgets\FromBuilder;

FormBuilder::widget([
    'div' => 'container',
    'data' => data, //JSON content, can be empty
    'mode' => 'run' //or 'build'
    'singleSection' => false,
    'debug' => false,
]); 
```

or 

```php
use pixium\widgets\FromBuilder;

$form->field($model, 'data')->widget(
        FormBuilder::class,
        [
            'div' => 'container',
            'data' => data, //JSON content, can be empty
            'mode' => 'run' //or 'build'
            'singleSection' => false,
            'debug' => false,
        ]
    );

```
