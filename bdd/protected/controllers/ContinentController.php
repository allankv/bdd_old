<?php
include 'logic/ContinentLogic.php';
class ContinentController extends CController {
    const PAGE_SIZE=10;
    // procura valores para autocomplete (ao digitar alguma coisa)
    public function actionSearch() {
        $logic = new ContinentLogic();
        $arList = $logic->search($_GET['term']);
        $rs = array();
        foreach ($arList as $n=>$ar) {
            $ln= array ("id"=>$ar->idcontinent+"","label"=>$ar->continent,"value"=>$ar->continent);
            $rs[] = $ln;
        }
        echo CJSON::encode($rs);
    }
    // salva (cria novo)
    public function actionSave() {
        $logic = new ContinentLogic();
        $ar = ContinentAR::model();
        $ar->continent = $_POST['field'];
        $rs = $logic->save($ar);
        if($rs['success']) {
            $rs['id'] = $rs['ar']->idcontinent;
            $rs['field'] = $rs['ar']->continent;
            $rs['ar'] = $rs['ar']->getAttributes();
        }
        echo CJSON::encode($rs);
    }
    // acao de recuperar registro a partir de string
    public function actionGetJSON() {
        $logic = new ContinentLogic();
        $ar = ContinentAR::model();
        $ar->continent= $_POST['field'];
        $ar->idcontinent = $_POST['id'];
        $ar = $logic->getContinent($ar);
        $rs = array();
        if($ar!=null) {
            $rs['success'] = true;
            $rs['id'] = $ar->idcontinent;
            $rs['field'] = $ar->continent;
            $rs['ar'] = $ar->getAttributes();
            echo CJSON::encode($rs);
        }else {
            $rs['success'] = false;
            echo CJSON::encode($rs);
        }
    }
    // janela de sugestoes para valores similares ao digitado no autocomplete
    public function actionSuggestion() {
        $logic = new ContinentLogic();
        $arList = $logic->suggestion($_POST['term']);
        $this->renderPartial('suggestion',array(
                'continentList'=>$arList,
                'term'=>$_POST['term'],
                '_id'=>$_POST['_id'],
                '_field'=>$_POST['_field'],
                'controller'=>$_POST['controller'],
        ));
    }
    public function filters() {
        return array(
                'accessControl', // perform access control for CRUD operations
        );
    }
    public function accessRules() {
        return array(
                array('allow',
                        'actions'=>array('*'),
                        'users'=>array('@'),
                )
        );
    }
}
