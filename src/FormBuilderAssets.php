<?php
namespace pixium\form_builder;

use yii\web\AssetBundle;

class FormBuilderAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/form-builder/assets'; //WIP: replace by npm call 
    // public $basePath = '@webroot';
    // public $baseUrl = '@web';
    public $css = ['assets/css/main.css'];
    public $js = [
        'assets/js/bundle.js'
    ];
    // public $depends = [
    //     'yii\web\JqueryAsset'
    // ];

    public function init()
    {
        // Tell AssetBundle where the assets files are
        $this->sourcePath = __DIR__.'/assets';
        $this->setupAssets('css', ['css/main']);
        $this->setupAssets('js', ['js/bundle']);
        parent::init();
    }
}
