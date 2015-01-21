<?php
include 'logic/ParentNameUsageLogic.php';
include 'SuggestionController.php';
class ParentnameusageController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new ParentNameUsageLogic();

        //Call parent function
        parent::filters();
    }
}
