<?php
include 'logic/CountyLogic.php';
include 'SuggestionController.php';
class CountyController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new CountyLogic();

        //Call parent function
        parent::filters();
    }
}
