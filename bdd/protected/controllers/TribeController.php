<?php
include 'logic/TribeLogic.php';
include 'SuggestionController.php';
class TribeController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new TribeLogic();

        //Call parent function
        parent::filters();
    }
}