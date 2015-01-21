<?php
include 'logic/PublisherLogic.php';
include 'SuggestionController.php';
class PublisherController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new PublisherLogic();

        //Call parent function
        parent::filters();
    }
}