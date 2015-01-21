<?php
include 'logic/WaterBodyLogic.php';
include 'SuggestionController.php';
class WaterbodyController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new WaterBodyLogic();

        //Call parent function
        parent::filters();
    }
}
