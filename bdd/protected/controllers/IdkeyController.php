<?php
include 'logic/IDKeyLogic.php';
class IdkeyController extends CController {
    
    public function actionSaveSpeciesNN() {
        $logic = new IDKeyLogic();
        print_r($_POST);
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }
}
