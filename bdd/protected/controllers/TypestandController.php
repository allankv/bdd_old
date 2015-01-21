<?php
include 'logic/TypeStandLogic.php';
include 'SuggestionController.php';
class TypestandController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new TypeStandLogic();

        //Call parent function
        parent::filters();
    }
}
