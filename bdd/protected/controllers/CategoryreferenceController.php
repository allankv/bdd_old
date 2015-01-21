<?php
include 'logic/CategoryReferenceLogic.php';
include 'SuggestionController.php';
class CategoryreferenceController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new CategoryReferenceLogic();

        //Call parent function
        parent::filters();
    }
}
