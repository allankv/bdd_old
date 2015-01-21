<?php
include 'logic/OriginSeedsLogic.php';
include 'SuggestionController.php';
class OriginseedsController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new OriginSeedsLogic();

        //Call parent function
        parent::filters();
    }
}
