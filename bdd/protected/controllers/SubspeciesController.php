<?php
include 'logic/SubspeciesLogic.php';
include 'SuggestionController.php';
class SubspeciesController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SubspeciesLogic();

        //Call parent function
        parent::filters();
    }
}