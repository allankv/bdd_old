<?php
include 'logic/ProductionVarietyLogic.php';
include 'SuggestionController.php';
class ProductionvarietyController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new ProductionVarietyLogic();

        //Call parent function
        parent::filters();
    }
}
