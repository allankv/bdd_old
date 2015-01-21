<?php
include 'logic/SexLogic.php';
include 'SuggestionController.php';
class SexController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SexLogic();

        //Call parent function
        parent::filters();
    }
}
