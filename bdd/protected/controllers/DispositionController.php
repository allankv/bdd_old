<?php
include 'logic/DispositionLogic.php';
include 'SuggestionController.php';
class DispositionController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new DispositionLogic();

        //Call parent function
        parent::filters();
    }
}
