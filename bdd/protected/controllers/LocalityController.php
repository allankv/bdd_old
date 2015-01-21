<?php
include 'logic/LocalityLogic.php';
include 'SuggestionController.php';
class LocalityController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new LocalityLogic();

        //Call parent function
        parent::filters();
    }
}
