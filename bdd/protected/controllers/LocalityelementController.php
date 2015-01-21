<?php
include 'logic/LocalityElementLogic.php';
class LocalityelementController extends CController {
    const PAGE_SIZE=10;
    // procura valores para autocomplete (ao digitar alguma coisa)
    public function actionSearch() {
        $logic = new LocalityElementLogic();
        $arList = $logic->search($_GET['term']);
        $rs = array();
        foreach ($arList as $n=>$ar) {
            $aux= '';
            $itens = explode(";", $ar->highergeograph);
            foreach ($itens as $n=>$i) {
                $aux = $i.', '.$aux;
            }
            $aux = preg_replace("/;$/", "", $aux);
            $aux = preg_replace("/^;/", "", $aux);
            $ln= array ("id"=>$ar->idlocalityelement+"","label"=>$aux,"value"=>$aux);
            $rs[] = $ln;
        }
        echo CJSON::encode($rs);
    }
    public function actionGetJSON() {
        $ar = LocalityElementAR::model()->findByPk($_POST['id']);
        $rs = array();
        if($ar!=null) {
            $aux =  CountryAR::model()->findByPk($ar->idcountry);
            $rs['country'] = $aux->country;
            $aux =  StateProvinceAR::model()->findByPk($ar->idstateprovince);
            $rs['stateprovince'] = $aux->stateprovince;
            $aux =  CountyAR::model()->findByPk($ar->idcounty);
            $rs['county'] = $aux->county;
            $aux =  MunicipalityAR::model()->findByPk($ar->idmunicipality);
            $rs['municipality'] = $aux->municipality;
            echo CJSON::encode($rs);
        }
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