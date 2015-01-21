<?php
include 'logic/IslandGroupLogic.php';
include 'SuggestionController.php';
class IslandgroupController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new IslandGroupLogic();

        //Call parent function
        parent::filters();
    }
}
