<?php
include 'logic/SpecificEpithetLogic.php';
include 'SuggestionController.php';
class SpecificepithetController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SpecificEpithetLogic();

        //Call parent function
        parent::filters();
    }
}
