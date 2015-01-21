//To create a new controller from the template:
//for example, for Georeference Verification Status controller,
//replace "TemplateUpperCase" with "GeoreferenceVerificationStatus" AND
//replace "templatecase" with "Georeferenceverificationstatus"

//Be careful with NN fields - leave those functions as they are.

<?php
include 'logic/TemplateUpperCaseLogic.php';
include 'SuggestionController.php';
class templatecaseController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new TemplateUpperCaseLogic();

        //Call parent function
        parent::filters();
    }
}
