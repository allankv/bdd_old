<?php
include 'logic/CaptureDeviceLogic.php';
include 'SuggestionController.php';
class CapturedeviceController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new CaptureDeviceLogic();

        //Call parent function
        parent::filters();
    }
}
