<?php
include 'logic/MonitoringLogic.php';
include 'logic/LogLogic.php';

include 'logic/print/MonitoringPrint.php';

class MonitoringController extends CController {
    const PAGE_SIZE=10;
    public $defaultAction='goToList';
    public function actionGoToList() {
        $this->render('list',array());
    }
    public function actionGoToMaintain() {
        if($_GET['id']!=null && MonitoringAR::model()->findByPk($_GET['id'])!=null) {
            $monitoring = MonitoringAR::model()->findByPk($_GET['id']);
        }else {
            $monitoring = MonitoringAR::model();
        }
        $logic = new MonitoringLogic();
        $monitoring = $logic->fillDependency($monitoring);
        $this->render('maintain',
                array_merge(array(
                'monitoring'=>$monitoring,
                )
        ));
    }
    public function actionGoToShow() {
        if($_GET['id']!=null && MonitoringAR::model()->findByPk($_GET['id'])!=null) {
            $monitoring = MonitoringAR::model()->findByPk($_GET['id']);
        }else {
            $monitoring = MonitoringAR::model();
        }
        $logic = new MonitoringLogic();
        $monitoring = $logic->fillDependency($monitoring);
        $this->render('show',
                array_merge(array(
                'monitoring'=>$monitoring,
                )
        ));
    }
    public function actionGoToPrint() {
        if($_GET['id']!=null && MonitoringAR::model()->findByPk($_GET['id'])!=null) {
            $monitoring = MonitoringAR::model()->findByPk($_GET['id']);
        }else {
            $monitoring = MonitoringAR::model();
        }
        $logic = new MonitoringLogic();
        $monitoring = $logic->fillDependency($monitoring);
        $this->renderPartial('print',
                array_merge(array(
                'monitoring'=>$monitoring,
                )
        ));
    }
    public function actionGetMonitoring() {
        $logic = new MonitoringLogic();
        $mon = MonitoringAR::model()->findByPk($_POST['id']);
        $mon = $logic->fillDependency($mon);

        $rs = array();
        $rs['mon'] = $mon->getAttributes();
        $rs['institutionCode'] = $mon->recordlevelelement->institutioncode->getAttributes();
        $rs['collectionCode'] =  $mon->recordlevelelement->collectioncode->getAttributes();
        $rs['occurrenceElement'] =  $mon->occurrenceelement->getAttributes();
        $rs['scientificName'] =  $mon->taxonomicelement->scientificname->getAttributes();

        echo CJSON::encode($rs);
    }
    public function actionSearch() {
        $logic = new MonitoringLogic();
        $rs = $logic->search($_GET['term']);
        echo CJSON::encode($rs);
    }
    public function actionFilter() {
        $l = new MonitoringLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filter($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],
                    "id" => $ar['idmonitoring'],
                    "catalognumber" => $ar['catalognumber'],
                    "scientificname" => $ar['scientificname'],
                    "institution" => $ar['institutioncode'],
                    "collection" => $ar['collectioncode'],
                    "denomination" => $ar['denomination'],
                    "morphospecies" => $ar['morphospecies']
            );
        }

        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    public function actionSave() {
        $mon = MonitoringAR::model();
        $mon->setAttributes($_POST['MonitoringAR'],false);
                
        $logic = new RecordLevelElementLogic();
        $mon->recordlevelelement = $logic->setAttributes($_POST['RecordLevelElementAR']);
        $logic = new OccurrenceElementLogic();
        $mon->occurrenceelement = $logic->setAttributes($_POST['OccurrenceElementAR']);
        $logic = new TaxonomicElementLogic();
        $mon->taxonomicelement = $logic->setAttributes($_POST['TaxonomicElementAR']);
        $logic = new LocalityElementLogic();
        $mon->localityelement = $logic->setAttributes($_POST['LocalityElementAR']);
        $logic = new GeospatialElementLogic();
        $mon->geospatialelement = $logic->setAttributes($_POST['GeospatialElementAR']);
        
        $logic = new MonitoringLogic();
        $rs = $logic->save($mon);

        if ($rs['success']) {
            $log = LogAR::model();
            $log->setAttributes(array(
                'iduser'=>Yii::app()->user->id,
                'date'=>date('Y-m-d'),
                'time'=>date('H:i:s'),
                'type'=>substr($rs['operation'],0,-1),
                'module'=>'monitoring',
                'source'=>'form',
                'id'=>$mon->idmonitoring,
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
            'module'=>'monitoring',
            'source'=>'form',
            'id'=>$_POST['id'],
            'transaction'=>null),false);
        $logic = new LogLogic();
        $logmsg = $logic->save($log);
    
        $logic = new MonitoringLogic();
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
        $l = new MonitoringLogic();
        $filter = array('idmonitoring'=>$_POST['idmonitoring']);
        $data = array();

        $rs = array();
        $rs['sp'] = $l->getTip($filter);


        echo CJSON::encode($rs);
    }
    public function actionPrint() {
	    $monitoring = MonitoringAR::model()->findByPk($_GET['id']);
        $logic = new MonitoringLogic();
        $monitoring = $logic->fillDependency($monitoring); 
        
        $print = new MonitoringPrint();
		$pathToPdf = $print->printMonitoring($monitoring);
		     
		echo CJSON::encode($pathToPdf);          
    }
    public function actionPrintList() {
        $l = new MonitoringLogic();
        $filter = array('limit'=>1000000,'offset'=>0,'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filter($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],
                    "id" => $ar['idmonitoring'],
                    "catalognumber" => $ar['catalognumber'],
                    "scientificname" => $ar['scientificname'],
                    "institution" => $ar['institutioncode'],
                    "collection" => $ar['collectioncode'],
                    "denomination" => $ar['denomination'],
                    "morphospecies" => $ar['morphospecies']
            );
        }

        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        
        $print = new MonitoringPrint();
		$pathToPdf = $print->printMonitoringList($rs);
        
        echo CJSON::encode($pathToPdf);
    }
    public function actionSearchLocalScientificName() {
        $logic = new MonitoringLogic();
        $rs = array();        
		$rs = $logic->searchLocalScientificName($_GET['term'],3, false);
        
        echo CJSON::encode($rs);
    }
}
