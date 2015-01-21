<?php
include 'logic/TypePlantingLogic.php';
include 'SuggestionController.php';
class TypeplantingController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new TypePlantingLogic();

        //Call parent function
        parent::filters();
    }
}
