<?php
include 'logic/TopograficalSituationLogic.php';
include 'SuggestionController.php';
class TopograficalsituationController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new TopograficalSituationLogic();

        //Call parent function
        parent::filters();
    }
}
