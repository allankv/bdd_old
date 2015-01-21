<?php
include 'logic/SubcategoryMediaLogic.php';
include 'SuggestionController.php';
class SubcategorymediaController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SubcategoryMediaLogic();

        //Call parent function
        parent::filters();
    }
}
