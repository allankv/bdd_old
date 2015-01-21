<?php
include 'logic/EstablishmentMeanLogic.php';
include 'SuggestionController.php';
class EstablishmentmeanController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new EstablishmentMeanLogic();

        //Call parent function
        parent::filters();
    }
}
