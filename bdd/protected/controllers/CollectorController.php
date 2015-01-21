<?php
include 'logic/CollectorLogic.php';
include 'SuggestionController.php';
class CollectorController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new CollectorLogic();

        //Call parent function
        parent::filters();
    }
}
