<?php
include 'logic/NamePublishedInLogic.php';
include 'SuggestionController.php';
class NamepublishedinController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new NamePublishedInLogic();

        //Call parent function
        parent::filters();
    }
}
