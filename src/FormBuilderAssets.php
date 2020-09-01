<?php
namespace pixium\widgets;

use yii\web\AssetBundle;

class FormBuilderAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/form-builder/assets'; //WIP: replace by npm call 
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    public $css = ['assets/css/main.css'];
    public $js = [
        'assets/bundle.js'
    ];
    // public $depends = [
    //     'yii\web\JqueryAsset'
    // ];

    public function init()
    {
        // Tell AssetBundle where the assets files are
        $this->sourcePath = __DIR__.'/assets';
        parent::init();
    }
}
