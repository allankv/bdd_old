<?php
include 'logic/MunicipalityLogic.php';
include 'SuggestionController.php';
class MunicipalityController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new MunicipalityLogic();

        //Call parent function
        parent::filters();
    }
}
