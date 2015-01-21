<?php
include 'logic/MainPlantSpeciesInHedgeLogic.php';
include 'SuggestionController.php';
class MainplantspeciesinhedgeController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new MainPlantSpeciesInHedgeLogic();

        //Call parent function
        parent::filters();
    }
}
