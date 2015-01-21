<?php
include 'logic/DenominationLogic.php';
include 'SuggestionController.php';
class DenominationController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new DenominationLogic();

        //Call parent function
        parent::filters();
    }
}
