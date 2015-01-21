<?php
include 'logic/SubgenusLogic.php';
include 'SuggestionController.php';
class SubgenusController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SubgenusLogic();

        //Call parent function
        parent::filters();
    }
}
