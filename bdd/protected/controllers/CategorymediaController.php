<?php
include 'logic/CategoryMediaLogic.php';
include 'SuggestionController.php';
class CategorymediaController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new CategoryMediaLogic();

        //Call parent function
        parent::filters();
    }
}
