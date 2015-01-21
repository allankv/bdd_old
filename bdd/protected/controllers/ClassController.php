<?php
include 'logic/ClassLogic.php';
include 'SuggestionController.php';
class ClassController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new ClassLogic();

        //Call parent function
        parent::filters();
    }
}
