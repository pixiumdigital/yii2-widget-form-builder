<?php
namespace pixium\form_builder;

use yii\base\Widget;
use yii\widgets\InputWidget;
use Yii;

/**
 * Widget renders a Form from and to JSON file
 *
 * ```php
 * FormBuilder::widget([
 *      'div' => 'container',
 *      'data' => data, //JSON
 *      'mode' => 'run' //or 'build',
 *      'hiddenInputId' => 'hidden-input-json'
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
    example :
    {
        "sections": [
            {
                "name": "Section Name",
                "blocks": [
                    {
                        "title": "Block Title",
                        "name": "question name",
                        "label": "Label question",
                        "type": 3
                    }
                ]
            }
        ]
    }
    */
    public $data = '{
                        "sections": [
                            {
                                "name": "Section Name",
                                "blocks": [
                                    {
                                        "title": "Block Title",
                                        "name": "question name",
                                        "label": "Label question",
                                        "type": 3
                                    }
                                ]
                            }
                        ]
                    }';

    /*
    To switch between the modes ['run', 'build'] of the FormBuilder
    */
    public $mode = 'run';

    /*
    Id for the result hidden input field
    */
    public $hiddenInputId = 'hidden-input-json';


    /**
     * {@inheritdoc}
     */
    public function run()
    {
        // parent::run();

        if($this->div){
            $div = $this->div;
        }

        if($this->data){
            $data = $this->data;
        }

        if($this->mode){
            $mode = $this->mode;
        }

        if($this->hiddenInputId){
            $hiddenInputId = $this->hiddenInputId;
        }

        $view = $this->getView();
        FormBuilderAssets::registerBundle($view);
        // FormBuilderAsset::register($view);    

        $formName = 'FormBuilder_' . hash('crc32', $hiddenInputId);
        // $this->options['data-form-build-name'] = $formName;
        $jsUpdateHiddenField = "jQuery('#$hiddenInputId').val($formName.getJson());";

        $jsCode = 
        // Init From builder Object
        "$formName = new Library.PixiumForm({
            'div': ".$div.",
            'data': ".$data.",
            'mode': ".$mode."
        });\n".
        // Run Instance
        "$formName.run();\n".
        // Create Hidden input file
        "jQuery('#$hiddenInputId').parents('form').submit(function() {{$jsUpdateHiddenField}});";

        // Add 
        $view->registerJs($jsCode);
    }
}
