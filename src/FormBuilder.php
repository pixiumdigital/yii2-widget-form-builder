<?php
namespace pixium\form_builder;

use yii\base\Widget;
use yii\widgets\InputWidget;
use yii\helpers\Inflector;

use Yii;
use yii\helpers\Html;

/**
 * Widget renders a Form from and to JSON file
 *
 * ```php
 * FormBuilder::widget([
 *      'div' => 'container',
 *      'data' => data, //JSON
 *      'mode' => 'run' //or 'build',
 *      //'hiddenInputId' => 'hidden-input-json'
 *   ]); 
 * ```
 */
class FormBuilder extends InputWidget
{

    /*
    Div to display the form
    */
    public $div = 'container';


    /*
    Json file that contains the formulaire
    */
    public $data;

    /*
    Default json form file
    */
    public $defaultData = '{
                                "sections": [
                                    {
                                        "name": "",
                                        "blocks": [
                                        ]
                                    }
                                ]
                            }';

    /*
    To switch between the modes ['run', 'build'] of the FormBuilder
    */
    public $mode = 'run';

    /**
     * @var array HTML attributes to be applied to the Form builder container tag
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered
     */
    public $containerOptions = [];

    // /*
    // Id for the result hidden input field
    // */
    // public $hiddenInputId = 'hidden-input-json';

   /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->options['id'] . '-form-builder';
        }

        // if($this->div){
        //     $div = $this->div;
        // }

        if(!$this->data){
            $this->data = $this->defaultData;
        }

        // if($this->mode){
        //     $mode = (string) $this->mode;
        // }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        // parent::run();
        echo Html::button('SAVE QUESTIONS', ['id' => 'form-builder-save-btn']);

        $this->registerClientScript();
        if ($this->hasModel()) {
            $this->options['value'] = $this->data; 
            // echo Html::activeHiddenInput($this->model, $this->attribute, $this->options);
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            // echo Html::hiddenInput($this->name, $this->value, $this->options);
            echo Html::textInput($this->name, $this->value, $this->options);
        }
        echo Html::tag('div', '', $this->containerOptions);
    }

        /**
     * Registers the needed client script.
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        FormBuilderAssets::register($view);
        // FormBuilderAsset::register($view);    

        $hiddenInputId = $this->options['id'];
        $formBuilderName = Inflector::variablize($hiddenInputId) . 'FormBuilder_' . hash('crc32', $hiddenInputId);
        // $this->options['data-form-build-name'] = $formBuilderName;
        // $jsUpdateHiddenField = "document.getElementById('$hiddenInputId').value = $formBuilderName.compileJson() ;";
        $jsUpdateHiddenField = "jQuery('#$hiddenInputId').val($formBuilderName.compileJson());";

        // if (isset($this->clientOptions['onChange'])) {
        //     $userFunction = " var userFunction = {$this->clientOptions['onChange']}; userFunction.call(this);";
        // } else {
        //     $userFunction = '';
        // }
        // $this->clientOptions['onChange'] = new JsExpression("function() {{$jsUpdateHiddenField}$userFunction}");

        $jsCode = 
        // Init From builder Object
        "$formBuilderName = new Library.PixiumForm({
            'div': '".$this->containerOptions['id']."',
            'data': ".$this->data.",
            'mode': '".$this->mode."'
        });\n"
        // Run Instance
        ."$formBuilderName.run();\n"
        // Set form submit to trigger jsonComplie
        // ."jQuery('#$hiddenInputId').parents('form').submit(function() { console.log($formBuilderName.compileJson()); {$jsUpdateHiddenField}});"
        // ."document.getElementById('$hiddenInputId').parentNode.closest('form').addEventListener('submit', (event) => {{$jsUpdateHiddenField}});"
        ."document.getElementById('form-builder-save-btn').onclick = function() {
            var textnode = document.createTextNode(".$formBuilderName.".compileJson()); 
            console.log(textnode);
            document.getElementById('".$this->containerOptions['id']."').appendChild(textnode);      
          }"
        ;

        // Add js to view 
        $view->registerJs($jsCode);
    }
}
