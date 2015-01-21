<?php
include 'logic/DatasetLogic.php';
include 'SuggestionController.php';
class DatasetController extends SuggestionController {

    public function filters() {
        //Personalize parameters
        $this->logic = new DatasetLogic();

        //Call parent function
        parent::filters();
    }
}
