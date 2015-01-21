<?php
include 'logic/OwnerInstitutionLogic.php';
include 'SuggestionController.php';
class OwnerinstitutionController extends SuggestionController {

    public function filters() {
        //Personalize parameters
        $this->logic = new OwnerInstitutionLogic();

        //Call parent function
        parent::filters();
    }
}
