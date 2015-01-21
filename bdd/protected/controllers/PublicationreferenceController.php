<?php
include 'logic/PublicationReferenceLogic.php';
class PublicationreferenceController extends CController {

    public function actionSaveSpeciesNN() {
        $logic = new PublicationReferenceLogic();
        print_r($_POST);
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }
}