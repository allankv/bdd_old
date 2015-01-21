<?php
include 'logic/IslandLogic.php';
include 'SuggestionController.php';
class IslandController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new IslandLogic();

        //Call parent function
        parent::filters();
    }
}
