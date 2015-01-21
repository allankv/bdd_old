<?php
include 'logic/TypeMediaLogic.php';
class TypemediaController extends CController {
    const PAGE_SIZE=10;
    // procura valores para autocomplete (ao digitar alguma coisa)
    public function actionSearch() {
        $logic = new TypeMediaLogic();
        $arList = $logic->search($_GET['term']);
        $rs = array();
        foreach ($arList as $n=>$ar) {
            $ln= array ("id"=>$ar->idtypemedia+"","label"=>$ar->typemedia,"value"=>$ar->typemedia);
            $rs[] = $ln;
        }
        echo CJSON::encode($rs);
    }
    // salva (cria novo)
    public function actionSave() {
        $logic = new TypeMediaLogic();
        $ar = TypeMediaAR::model();
        $ar->typemedia = $_POST['field'];
        $rs = $logic->save($ar);
        if($rs['success']) {
            $rs['id'] = $rs['ar']->idtypemedia;
            $rs['field'] = $rs['ar']->typemedia;
            $rs['ar'] = $rs['ar']->getAttributes();
        }
        echo CJSON::encode($rs);
    }
    // acao de recuperar registro a partir de string
    public function actionGetJSON() {
        $logic = new TypeMediaLogic();
        $ar = TypeMediaAR::model();
        $ar->typemedia = $_POST['field'];
        $ar->idtypemedia = $_POST['id'];
        $ar = $logic->getTypeMedia($ar);
        $rs = array();
        if($ar!=null) {
            $rs['success'] = true;
            $rs['id'] = $ar->idtypemedia;
            $rs['field'] = $ar->typemedia;
            $rs['ar'] = $ar->getAttributes();
            echo CJSON::encode($rs);
        }else {
            $rs['success'] = false;
            echo CJSON::encode($rs);
        }
    }
    // janela de sugestoes para valores similares ao digitado no autocomplete
    public function actionSuggestion() {
        $logic = new TypeMediaLogic();
        $arList = $logic->suggestion($_POST['term']);
        $this->renderPartial('suggestion',array(
                'typeMediaList'=>$arList,
                'term'=>$_POST['term'],
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
