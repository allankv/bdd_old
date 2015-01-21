<?php
include 'logic/OriginalNameUsageLogic.php';
include 'SuggestionController.php';
class OriginalnameusageController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new OriginalNameUsageLogic();

        //Call parent function
        parent::filters();
    }
}
