<?php
include 'logic/InstitutionCodeLogic.php';
include 'SuggestionController.php';
class InstitutioncodeController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new InstitutionCodeLogic();

        //Call parent function
        parent::filters();
    }
}