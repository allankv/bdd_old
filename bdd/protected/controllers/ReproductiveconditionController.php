<?php
include 'logic/ReproductiveConditionLogic.php';
include 'SuggestionController.php';
class ReproductiveconditionController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new ReproductiveConditionLogic();

        //Call parent function
        parent::filters();
    }
}
