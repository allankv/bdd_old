<?php
include 'logic/SurroundingsVegetationLogic.php';
include 'SuggestionController.php';
class SurroundingsvegetationController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SurroundingsVegetationLogic();

        //Call parent function
        parent::filters();
    }
}