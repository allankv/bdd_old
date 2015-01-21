<?php
include 'logic/Site_Logic.php';
include 'SuggestionController.php';
class Site_Controller extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new Site_Logic();

        //Call parent function
        parent::filters();
    }
}
