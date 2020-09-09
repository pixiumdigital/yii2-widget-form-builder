<?php
namespace pixium\form_builder;

use yii\widgets\InputWidget;
use yii\helpers\Inflector;
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
    public $defaultData = '{"sections": [{"name": "", "blocks": []}]}';

    /*
    To switch between the modes ['run', 'build'] of the FormBuilder
    */
    public $mode = 'run';

    /**
     * @var array HTML attributes to be applied to the Form builder container tag
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered
     */
    public $containerOptions = [];

    /*
    To switch between to debug mode which include display Go to run / build btns
    */
    public $debug = false;

   /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->options['id'] . '-form-builder';
        }

        if(!$this->data){
            $this->data = $this->defaultData;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        // parent::run();
        //Create temporary external save btn with same id as interne save btn
        // echo Html::button('SAVE QUESTIONS', ['id' => 'form-builder-save-btn']);

        $this->registerClientScript();
        if ($this->hasModel()) {
            $this->options['value'] = $this->data; 
            echo Html::activeHiddenInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::hiddenInput($this->name, $this->value, $this->options);
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

        $hiddenInputId = $this->options['id'];
        $formBuilderName = Inflector::variablize($hiddenInputId) . 'FormBuilder_' . hash('crc32', $hiddenInputId);
        $jsUpdateHiddenField = "document.getElementById('$hiddenInputId').value = $formBuilderName.compileJson() ;";

        $jsCode = 
        // Init From builder Object
        "$formBuilderName = new Library.PixiumForm({
            'div': '".$this->containerOptions['id']."',
            'data': ".$this->data.",
            'mode': '".$this->mode."',
            'debug': '".$this->debug."',
        });\n"
        // Display run or build form depending on mode chosen 
        ."$formBuilderName.$this->mode();\n"
        // Set form submit to trigger jsonComplie
        ."document.getElementById('$hiddenInputId').parentNode.closest('form').addEventListener('submit', function(){{$jsUpdateHiddenField}});"
        // add onclick event to save btn
        // ."document.getElementById('form-builder-save-btn').onclick = function() {$jsUpdateHiddenField}"
        ;

        // Add js to view 
        $view->registerJs($jsCode);
    }
}
