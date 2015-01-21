<?php
include 'logic/CountryLogic.php';
include 'SuggestionController.php';
class CountryController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new CountryLogic();

        //Call parent function
        parent::filters();
    }
}
