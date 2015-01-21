<?php
include 'logic/BasisOfRecordLogic.php';
class BasisofrecordController extends CController {
    const PAGE_SIZE=10;
    // procura valores para autocomplete (ao digitar alguma coisa)
    public function actionSearch() {
        $logic = new BasisOfRecordLogic();
        $arList = $logic->search($_GET['term']);
        $rs = array();
        foreach ($arList as $n=>$ar) {
            $ln= array ("id"=>$ar->idbasisofrecord+"","label"=>$ar->basisofrecord,"value"=>$ar->basisofrecord);
            $rs[] = $ln;
        }
        echo CJSON::encode($rs);
    }
    // salva (cria novo)
    public function actionSave() {
        $logic = new BasisOfRecordLogic();
        $ar = BasisOfRecordAR::model();
        $ar->basisofrecord = $_POST['field'];
        $rs = $logic->save($ar);
        if($rs['success']) {
            $rs['id'] = $rs['ar']->idbasisofrecord;
            $rs['field'] = $rs['ar']->basisofrecord;
            $rs['ar'] = $rs['ar']->getAttributes();
        }
        echo CJSON::encode($rs);
    }
    // acao de recuperar registro a partir de string
    public function actionGetJSON() {
        $logic = new BasisOfRecordLogic();
        $ar = BasisOfRecordAR::model();
        $ar->basisofrecord = $_POST['field'];
        $ar->idbasisofrecord = $_POST['id'];
        $ar = $logic->getBasisOfRecord($ar);
        $rs = array();
        if($ar!=null) {
            $rs['success'] = true;
            $rs['id'] = $ar->idbasisofrecord;
            $rs['field'] = $ar->basisofrecord;
            $rs['ar'] = $ar->getAttributes();
            echo CJSON::encode($rs);
        }else {
            $rs['success'] = false;
            echo CJSON::encode($rs);
        }
    }
    // janela de sugestoes para valores similares ao digitado no autocomplete
    public function actionSuggestion() {
        $logic = new BasisOfRecordLogic();
        $arList = $logic->suggestion($_POST['term']);
        $this->renderPartial('suggestion',array(
                'basisOfRecordList'=>$arList,
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
