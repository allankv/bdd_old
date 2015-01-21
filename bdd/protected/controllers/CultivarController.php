<?php
include 'logic/CultivarLogic.php';
include 'SuggestionController.php';
class CultivarController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new CultivarLogic();

        //Call parent function
        parent::filters();
    }
}
