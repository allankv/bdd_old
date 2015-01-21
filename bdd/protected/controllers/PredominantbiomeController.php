<?php
include 'logic/PredominantBiomeLogic.php';
include 'SuggestionController.php';
class PredominantbiomeController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new PredominantBiomeLogic();

        //Call parent function
        parent::filters();
    }
}
