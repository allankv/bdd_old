<?php
include 'logic/SurroundingsCultureLogic.php';
include 'SuggestionController.php';
class SurroundingscultureController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SurroundingsCultureLogic();

        //Call parent function
        parent::filters();
    }
}
