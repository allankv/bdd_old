<?php
include 'logic/SoilTypeLogic.php';
include 'SuggestionController.php';
class SoiltypeController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SoilTypeLogic();

        //Call parent function
        parent::filters();
    }
}
