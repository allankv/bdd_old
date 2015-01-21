<?php
include 'logic/TaxonConceptLogic.php';
include 'SuggestionController.php';
class TaxonconceptController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new TaxonConceptLogic();

        //Call parent function
        parent::filters();
    }
}
