<?php
include 'logic/BehaviorLogic.php';
include 'SuggestionController.php';
class BehaviorController extends SuggestionController
{  
    public function filters() {
        //Personalize parameters
        $this->logic = new BehaviorLogic();

        //Call parent function
        parent::filters();
    }
}
