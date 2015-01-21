<?php
include_once 'protected/controllers/logic/UserPanelLogic.php';

class UserpanelController extends CController
{
    const PAGE_SIZE=10;

    public function actionGetCollectionCodes() {        
        $logic = new UserPanelLogic();        
        $ic = array('idinstitutioncode' => $_POST['idinstitutioncode']);
        $result = $logic->getCollectionCodes($ic);
        
        $rs = array();
        $list = array();

        foreach($result['list'] as $n=>$ar) {
            $list[] = array(
                "collectioncode" => $ar['collectioncode'],
                "idcollectioncode" => $ar['idcollectioncode']
            );
        }

        $rs['result'] = $list;
        $rs['count'] = $result['count'][0]['count'];
        
        echo CJSON::encode($rs);
    }
    public function actionGetSpecimenInfo() {
        $logic = new UserPanelLogic();
        $filter = array('idinstitutioncode' => $_POST['idinstitutioncode'], 'idcollectioncode' => $_POST['idcollectioncode']);
        $result = $logic->getSpecimenInfo($filter);

        $rs = array();
        $list = array();

        foreach($result['list'] as $n=>$ar) {
            $list[] = array(
            	"basisofrecord" => $ar['basisofrecord'],
                "institutioncode" => $ar['institutioncode'],
                "collectioncode" => $ar['collectioncode'],
                "scientificname" => $ar['scientificname'],
                "latitude" => $ar['decimallatitude'],
                "longitude" => $ar['decimallongitude'],
                "country" => $ar['country'],
                "stateprovince" => $ar['stateprovince'],
                "municipality" => $ar['municipality']
            );
        }

        $rs['result'] = $list;
        $rs['count'] = $result['count'][0]['count'];

        echo CJSON::encode($rs);
    }
    public function actionGetInteractionInfo() {
        $logic = new UserPanelLogic();
        $ic = array('idinstitutioncode' => $_POST['idinstitutioncode']);
        $result = $logic->getInteractionInfo($ic);

        $rs = array();
        $list = array();

        foreach($result['list'] as $n=>$ar) {
            $list[] = array(
                "interactiontype" => $ar['interactiontype']
            );
        }

        $rs['result'] = $list;
        $rs['count'] = $result['count'][0]['count'];

        echo CJSON::encode($rs);
    }
}
