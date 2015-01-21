<?php
include 'logic/CollectionCodeLogic.php';
include 'SuggestionController.php';
class CollectioncodeController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new CollectionCodeLogic();

        //Call parent function
        parent::filters();
    }
}