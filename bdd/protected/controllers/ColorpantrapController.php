<?php
include 'logic/ColorPanTrapLogic.php';
include 'SuggestionController.php';
class ColorpantrapController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new ColorPanTrapLogic();

        //Call parent function
        parent::filters();
    }
}
