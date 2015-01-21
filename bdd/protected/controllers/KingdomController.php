<?php
include 'logic/KingdomLogic.php';
include 'SuggestionController.php';
class KingdomController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new KingdomLogic();

        //Call parent function
        parent::filters();
    }
}
