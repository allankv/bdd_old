<?php
include 'logic/SubcategoryReferenceLogic.php';
include 'SuggestionController.php';
class SubcategoryreferenceController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SubcategoryReferenceLogic();

        //Call parent function
        parent::filters();
    }
}
