<?php
namespace pixium\form_builder;

use yii\web\AssetBundle;

class FormBuilderAssets extends AssetBundle
{ 
    public $css = [
        ''
    ];
    public $js = [
        './assets/bundleIM.js'
    ];

    public function init()
    {
        // Tell AssetBundle where the assets files are
        $this->sourcePath = __DIR__.'/assets';
        parent::init();
    }
}