<?php
include 'logic/InfraspecificEpithetLogic.php';
include 'SuggestionController.php';
class InfraspecificepithetController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new InfraspecificEpithetLogic();

        //Call parent function
        parent::filters();
    }
}