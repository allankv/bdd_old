<?php
include 'logic/FocusCropLogic.php';
include 'SuggestionController.php';
class FocuscropController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new FocusCropLogic();

        //Call parent function
        parent::filters();
    }
}
