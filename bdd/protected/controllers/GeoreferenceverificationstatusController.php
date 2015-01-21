<?php
include 'logic/GeoreferenceVerificationStatusLogic.php';
include 'SuggestionController.php';
class GeoreferenceverificationstatusController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new GeoreferenceVerificationStatusLogic();

        //Call parent function
        parent::filters();
    }
}
