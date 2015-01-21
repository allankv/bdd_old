<?php
include 'logic/CommonNameFocalCropLogic.php';
include 'SuggestionController.php';
class CommonnamefocalcropController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new CommonNameFocalCropLogic();

        //Call parent function
        parent::filters();
    }
}
