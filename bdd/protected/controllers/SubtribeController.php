<?php
include 'logic/SubtribeLogic.php';
include 'SuggestionController.php';
class SubtribeController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SubtribeLogic();

        //Call parent function
        parent::filters();
    }
}