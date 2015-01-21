<?php
include 'logic/NameAccordingToLogic.php';
include 'SuggestionController.php';
class NameaccordingtoController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new NameAccordingToLogic();

        //Call parent function
        parent::filters();
    }
}
