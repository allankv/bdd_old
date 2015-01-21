<?php
include 'logic/TypeHoldingLogic.php';
include 'SuggestionController.php';
class TypeholdingController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new TypeHoldingLogic();

        //Call parent function
        parent::filters();
    }
}
