<?php
include 'logic/MetadataProviderLogic.php';
include 'SuggestionController.php';
class MetadataproviderController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new MetadataProviderLogic();

        //Call parent function
        parent::filters();
    }
}
