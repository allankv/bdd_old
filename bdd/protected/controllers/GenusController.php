<?php
include 'logic/GenusLogic.php';
include 'SuggestionController.php';
class GenusController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new GenusLogic();

        //Call parent function
        parent::filters();
    }
}
