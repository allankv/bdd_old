<?php
include 'logic/PhylumLogic.php';
include 'SuggestionController.php';
class PhylumController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new PhylumLogic();

        //Call parent function
        parent::filters();
    }
}
