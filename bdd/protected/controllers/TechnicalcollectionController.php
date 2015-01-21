<?php
include 'logic/TechnicalCollectionLogic.php';
include 'SuggestionController.php';
class TechnicalcollectionController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new TechnicalCollectionLogic();

        //Call parent function
        parent::filters();
    }
}
