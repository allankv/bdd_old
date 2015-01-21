<?php
class SuggestionController extends CController
{
    const PAGE_SIZE=10;
    protected $logic;

    // procura valores para autocomplete (ao digitar alguma coisa)
    public function actionSearch() {
        $arList = $this->logic->search($_GET['term']==null?$_GET['tag']:$_GET['term']);
        echo CJSON::encode($arList);
    }
    // procura valor identico
    public function actionSearchEqual() {
        $arList = $this->logic->searchEqual($_GET['term']);
        echo CJSON::encode($arList);
    }
    // salva (cria novo)
    public function actionSave() {
        $rs = $this->logic->save($_POST['field']);
        echo CJSON::encode($rs);
    }
    // acao de recuperar registro a partir de string
    public function actionGetJSON() {
        $rs = $this->logic->getJSON($_POST['field'], $_POST['id']);
        echo CJSON::encode($rs);
    }
    // janela de sugestoes para valores similares ao digitado no autocomplete
    public function actionSuggestion() {
        $arList = $this->logic->suggestion($_POST['term']);
           
        $this->renderPartial('suggestion',array(
                'listName'=>$arList,
                'term'=>$_POST['term'],
                '_id'=>$_POST['_id'],
                '_field'=>$_POST['_field'],
                'controller'=>$_POST['controller'],
        ));
    }
    public function actionSuggestionNN() {
        $arList = $this->logic->suggestion($_POST['term']);
        $this->renderPartial('suggestion',array(
                'listName'=>$arList,
                'term'=>$_POST['term'],
                //'_id'=>$_POST['_id'],
                '_field'=>$_POST['_field'],
                'controllerItem'=>$_POST['controllerItem'],
                'controllerElement'=>$_POST['controllerElement']
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
