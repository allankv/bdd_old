<?php
include 'logic/CultureLogic.php';
include 'SuggestionController.php';
class CultureController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new CultureLogic();

        //Call parent function
        parent::filters();
    }
}
