<?php
include 'logic/SamplingProtocolLogic.php';
include 'SuggestionController.php';
class SamplingprotocolController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SamplingProtocolLogic();

        //Call parent function
        parent::filters();
    }
}
