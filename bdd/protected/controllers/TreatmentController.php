<?php
include 'logic/TreatmentLogic.php';
include 'SuggestionController.php';
class TreatmentController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new TreatmentLogic();

        //Call parent function
        parent::filters();
    }
}
