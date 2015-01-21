<?php
include 'logic/DigitizerLogic.php';
include 'SuggestionController.php';
class DigitizerController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new DigitizerLogic();

        //Call parent function
        parent::filters();
    }
}
