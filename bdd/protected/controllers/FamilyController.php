<?php
include 'logic/FamilyLogic.php';
include 'SuggestionController.php';
class FamilyController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new FamilyLogic();

        //Call parent function
        parent::filters();
    }
}
