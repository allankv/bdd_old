<?php
include 'logic/SpeciesNameLogic.php';
include 'SuggestionController.php';
class SpeciesnameController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SpeciesNameLogic();

        //Call parent function
        parent::filters();
    }
}