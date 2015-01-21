<?php
include 'logic/NomenclaturalCodeLogic.php';
include 'SuggestionController.php';
class NomenclaturalcodeController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new NomenclaturalCodeLogic();

        //Call parent function
        parent::filters();
    }
}
