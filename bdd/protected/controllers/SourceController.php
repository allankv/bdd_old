<?php
include 'logic/SourceLogic.php';
include 'SuggestionController.php';
class SourceController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SourceLogic();

        //Call parent function
        parent::filters();
    }
}