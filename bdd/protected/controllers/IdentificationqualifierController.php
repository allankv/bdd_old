<?php
include 'logic/IdentificationQualifierLogic.php';
include 'SuggestionController.php';
class IdentificationqualifierController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new IdentificationQualifierLogic();

        //Call parent function
        parent::filters();
    }
}
