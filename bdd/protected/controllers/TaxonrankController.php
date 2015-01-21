<?php
include 'logic/TaxonRankLogic.php';
include 'SuggestionController.php';
class TaxonrankController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new TaxonRankLogic();

        //Call parent function
        parent::filters();
    }
}
