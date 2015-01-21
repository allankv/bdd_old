<?php
include 'logic/ScientificNameAuthorshipLogic.php';
include 'SuggestionController.php';
class ScientificnameauthorshipController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new ScientificNameAuthorshipLogic();

        //Call parent function
        parent::filters();
    }
}
