<?php
/**
 * @author Alexey Samoylov <alexey.samoylov@gmail.com>
 */
class UnsavedFormWidget extends CWidget
{
    /** @var string */
    public $message;
    /** @var CActiveForm */
    public $form;

    public function init()
    {
        if (empty($this->message)) {
            throw new CException('Empty message');
        }

        if (!$this->form instanceof CActiveForm) {
            throw new CException('Wrong form model');
        }
    }

    public function run()
    {
        /** @var CClientScript $cs */
        $cs = Yii::app()->clientScript;
        $cs->registerScript('UnsavedForm', '
            var unsavedFormWarning = false;
            $(window).on("beforeunload", function(){
                if (unsavedFormWarning)
                    return "'.CHtml::encode($this->message).'";
            });
            $("#'.$this->form->id.' :input").change(function(){
                unsavedFormWarning = true;
            });

            $("#'.$this->form->id.' :input").keyup(function(){
                unsavedFormWarning = true;
            });

            $("#'.$this->form->id.'").submit(function(){
                unsavedFormWarning = false;
            });

        ', CClientScript::POS_READY);
    }
}
