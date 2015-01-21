<?php
include 'logic/OrderLogic.php';
include 'SuggestionController.php';
class OrderController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new OrderLogic();

        //Call parent function
        parent::filters();
    }
}
