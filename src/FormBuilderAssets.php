<?php
namespace pixium\form_builder;

use yii\web\AssetBundle;

class FormBuilderAssets extends AssetBundle
{
    // public $sourcePath = '@app/widgets/form-builder/assets'; //WIP: replace by npm call 
    public $css = ['css/main.css'];
    public $js = [
        'js/bundle.js'
    ];

    public function init()
    {
        // Tell AssetBundle where the assets files are
        $this->sourcePath = __DIR__.'/assets';
        parent::init();
    }
}