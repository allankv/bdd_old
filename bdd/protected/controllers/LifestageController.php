<?php
include 'logic/LifeStageLogic.php';
include 'SuggestionController.php';
class LifestageController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new LifeStageLogic();

        //Call parent function
        parent::filters();
    }
}
