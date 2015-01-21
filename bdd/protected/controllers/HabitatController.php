<?php
include 'logic/HabitatLogic.php';
include 'SuggestionController.php';
class HabitatController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new HabitatLogic();

        //Call parent function
        parent::filters();
    }
}
