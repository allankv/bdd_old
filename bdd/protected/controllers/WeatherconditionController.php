<?php
include 'logic/WeatherConditionLogic.php';
include 'SuggestionController.php';
class WeatherconditionController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new WeatherConditionLogic();

        //Call parent function
        parent::filters();
    }
}
