<?php
include 'logic/ScientificNameLogic.php';
include 'SuggestionController.php';
class ScientificnameController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new ScientificNameLogic();

        //Call parent function
        parent::filters();
    }
}