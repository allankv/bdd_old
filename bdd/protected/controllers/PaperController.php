<?php
include 'logic/PaperLogic.php';
class PaperController extends CController {

    public function actionSaveSpeciesNN() {
        $logic = new PaperLogic();
        print_r($_POST);
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }

}
