<?php
include 'logic/SoilPreparationLogic.php';
include 'SuggestionController.php';
class SoilpreparationController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SoilPreparationLogic();

        //Call parent function
        parent::filters();
    }
}
