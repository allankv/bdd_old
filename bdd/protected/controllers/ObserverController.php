<?php
include 'logic/ObserverLogic.php';
include 'SuggestionController.php';
class ObserverController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new ObserverLogic();

        //Call parent function
        parent::filters();
    }
}
