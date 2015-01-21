<?php
include 'logic/StateProvinceLogic.php';
include 'SuggestionController.php';
class StateprovinceController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new StateProvinceLogic();

        //Call parent function
        parent::filters();
    }
}
