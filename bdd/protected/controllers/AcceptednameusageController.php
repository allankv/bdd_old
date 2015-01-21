<?php
include 'logic/AcceptedNameUsageLogic.php';
include 'SuggestionController.php';
class AcceptednameusageController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new AcceptedNameUsageLogic();

        //Call parent function
        parent::filters();
    }
}
