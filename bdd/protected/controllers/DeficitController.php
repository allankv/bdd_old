<?php
include 'logic/DeficitLogic.php';
include 'logic/LogLogic.php';

include 'logic/print/DeficitPrint.php';


class DeficitController extends CController {
    const PAGE_SIZE=10;
    public $defaultAction='goToList';
    public function actionGoToList() {
        $this->render('list',array(
            'related'=>'no',
        ));
    }
    public function actionGoToMaintain() {
        if($_GET['id']!=null && DeficitAR::model()->findByPk($_GET['id'])!=null) {
            $deficit = DeficitAR::model()->findByPk($_GET['id']);
        }else {
            $deficit = DeficitAR::model();
        }
        $logic = new DeficitLogic();
        $deficit = $logic->fillDependency($deficit);
        $this->render('maintain',
                array_merge(array(
                'deficit'=>$deficit,
                )
        ));
    }
    public function actionGoToShow() {
        if($_GET['id']!=null && DeficitAR::model()->findByPk($_GET['id'])!=null) {
            $deficit = DeficitAR::model()->findByPk($_GET['id']);
        }else {
            $deficit = DeficitAR::model();
        }
        $logic = new DeficitLogic();
        $deficit = $logic->fillDependency($deficit);
        $this->render('show',
                array_merge(array(
                'deficit'=>$deficit,
                )
        ));
    }
    public function actionGoToPrint() {
        if($_GET['id']!=null && DeficitAR::model()->findByPk($_GET['id'])!=null) {
            $deficit = DeficitAR::model()->findByPk($_GET['id']);
        }else {
            $deficit = DeficitAR::model();
        }
        $logic = new DeficitLogic();
        $deficit = $logic->fillDependency($deficit);
        $this->renderPartial('print',
                array_merge(array(
                'deficit'=>$deficit,
                )
        ));
    }
    public function actionSearch() {
        $logic = new DeficitLogic();
        $rs = $logic->search($_GET['term']);
        echo CJSON::encode($rs);
    }
    public function actionFilter() {
        $l = new DeficitLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list']);
        $rs = array();

        $defList = $l->filter($filter);
        $list = array();
        foreach($defList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],
                    "iddeficit" => $ar['iddeficit'],
                    "fieldnumber" => $ar['fieldnumber'],
                    "commonnamefocalcrop" => $ar['commonnamefocalcrop'],
                    "country" => $ar['country'],
                    "stateprovince" => $ar['stateprovince'],
                    "county" => $ar['county'],
                    "municipality" => $ar['municipality'],
                    "locality" => $ar['locality'],
                    "site_" => $ar['site_'],
                    "scientificname" => $ar['scientificname'],
                );
        }

        $rs['result'] = $list;
        $rs['count'] = $defList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    public function actionSave() {
        $ar = DeficitAR::model();
        $ar->setAttributes($_POST['DeficitAR'],false);
        
        $logic = new LocalityElementLogic();
        $ar->localityelement = $logic->setAttributes($_POST['LocalityElementAR']);
        $logic = new GeospatialElementLogic();
        $ar->geospatialelement = $logic->setAttributes($_POST['GeospatialElementAR']);
        
        $logic = new DeficitLogic();
        // $ar = $logic->setAttributes($_POST['DeficitAR']);
        $rs = $logic->save($ar);
        
        if ($rs['success']) {
            $log = LogAR::model();
            $log->setAttributes(array(
                'iduser'=>Yii::app()->user->id,
                'date'=>date('Y-m-d'),
                'time'=>date('H:i:s'),
                'type'=>substr($rs['operation'],0,-1),
                'module'=>'deficit',
                'source'=>'form',
                'id'=>$ar->iddeficit,
                'transaction'=>null),false);
            $logic = new LogLogic();
            $logmsg = $logic->save($log);        
        }
        
        echo CJSON::encode($rs);
    }
    public function actionDelete() {
        $log = LogAR::model();
        $log->setAttributes(array(
            'iduser'=>Yii::app()->user->id,
            'date'=>date('Y-m-d'),
            'time'=>date('H:i:s'),
            'type'=>'delete',
            'module'=>'deficit',
            'source'=>'form',
            'id'=>$_POST['id'],
            'transaction'=>null),false);
        $logic = new LogLogic();
        $logmsg = $logic->save($log);
        
        $logic = new DeficitLogic();
        $logic->delete($_POST['id']);
    }
    public function filters() {
        return array(
                'accessControl', // perform access control for CRUD operations
        );
    }
    public function accessRules() {
        return array(
                array('deny',
                        'users'=>array('?'),
                ),
        );
    }
    public function actionGetTip()
    {
        $l = new DeficitLogic();
        $filter = array('iddeficit'=>$_POST['iddeficit']);
        $data = array();

        $rs = array();
        $rs['sp'] = $l->getTip($filter);

        echo CJSON::encode($rs);
    }
    public function actionPrint() {
	    $deficit = DeficitAR::model()->findByPk($_GET['id']);
        $logic = new DeficitLogic();
        $deficit = $logic->fillDependency($deficit); 
        
        $print = new DeficitPrint();
		$pathToPdf = $print->printDeficit($deficit);
		     
		echo CJSON::encode($pathToPdf);          
    }
    public function actionPrintList() {
        $l = new DeficitLogic();
        $filter = array('limit'=>1000000,'offset'=>0,'list'=>$_POST['list']);
        $rs = array();

        $defList = $l->filter($filter);
        $list = array();
        foreach($defList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],
                    "iddeficit" => $ar['iddeficit'],
                    "fieldnumber" => $ar['fieldnumber'],
                    "commonnamefocalcrop" => $ar['commonnamefocalcrop'],
                    "country" => $ar['country'],
                    "stateprovince" => $ar['stateprovince'],
                    "county" => $ar['county'],
                    "municipality" => $ar['municipality'],
                    "locality" => $ar['locality'],
                    "site_" => $ar['site_'],
                    "scientificname" => $ar['scientificname'],
                );
        }

        $rs['result'] = $list;
        $rs['count'] = $defList['count'][0]['count'];
        
        $print = new DeficitPrint();
		$pathToPdf = $print->printDeficitList($rs);
        
        echo CJSON::encode($pathToPdf);
    }
}
