<?php
include 'logic/InteractionLogic.php';
include 'logic/LogLogic.php';  

include 'logic/print/InteractionPrint.php';

class InteractionController extends CController {
    const PAGE_SIZE=10;
    public $defaultAction='goToList';
    public function actionGoToList() {
        $this->render('list',array());
    }
    public function actionGoToMaintain() {
        if($_GET['id']!=null && InteractionAR::model()->findByPk($_GET['id'])!=null) {
            $interaction = InteractionAR::model()->findByPk($_GET['id']);
        }else {
            $interaction  = InteractionAR::model();
        }
        $logic = new InteractionLogic();
        $interaction = $logic->fillDependency($interaction);
        $this->render('maintain',
                array_merge(array(
                'interaction'=>$interaction,
                )
        ));
    }
    public function actionGoToShow() {
        if($_GET['id']!=null && InteractionAR::model()->findByPk($_GET['id'])!=null) {
            $interaction = InteractionAR::model()->findByPk($_GET['id']);
        }else {
            $interaction  = InteractionAR::model();
        }
        $logic = new InteractionLogic();
        $interaction = $logic->fillDependency($interaction);
        $this->render('show',
                array_merge(array(
                'interaction'=>$interaction,
                )
        ));
    }
    public function actionGoToPrint() {
        if($_GET['id']!=null && InteractionAR::model()->findByPk($_GET['id'])!=null) {
            $interaction = InteractionAR::model()->findByPk($_GET['id']);
        }else {
            $interaction  = InteractionAR::model();
        }
        $logic = new InteractionLogic();
        $interaction = $logic->fillDependency($interaction);
        $this->renderPartial('print',
                array_merge(array(
                'interaction'=>$interaction,
                )
        ));
    }
    public function actionSave() {
        $ar = InteractionAR::model();
        $ar->setAttributes($_POST['InteractionAR'],false);
        $ar->idgroup = Yii::app()->user->getGroupId();
        $logic = new InteractionLogic();
        $rs = $logic->save($ar);
        
        if ($rs['success']) {
            $log = LogAR::model();
            $log->setAttributes(array(
                'iduser'=>Yii::app()->user->id,
                'date'=>date('Y-m-d'),
                'time'=>date('H:i:s'),
                'type'=>substr($rs['operation'],0,-1),
                'module'=>'interaction',
                'source'=>'form',
                'id'=>$ar->idinteraction,
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
            'module'=>'interaction',
            'source'=>'form',
            'id'=>$_POST['id'],
            'transaction'=>null),false);
        $logic = new LogLogic();
        $logmsg = $logic->save($log);
        
        $logic = new InteractionLogic();
        $logic->delete($_POST['id']);
    }
    public function actionSearch() {
        $logic = new InteractionLogic();
        $rs = $logic->search($_GET['term']);
        echo CJSON::encode($rs);
    }
    public function actionFilter() {
        $l = new InteractionLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filter($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],
                    "id" => $ar['idinteraction'],
                    "catalognumber1" => $ar['catalognumber1'],
                    "scientificname1" => $ar['scientificname1'],
                    "catalognumber2" => $ar['catalognumber2'],
                    "scientificname2" => $ar['scientificname2'],
                    "institution1" => $ar['institutioncode1'],
                    "institution2" => $ar['institutioncode2'],
                    "collection1" => $ar['collectioncode1'],
                    "collection2" => $ar['collectioncode2'],
                    "interactiontype" => $ar['interactiontype']
            );
        }
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
	public function actionGetInteractionType() {
		$ar = InteractionTypeAR::model();

        echo CJSON::encode($ar->findByPk($_POST['id'])->getAttributes());
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
        $l = new InteractionLogic();
        $filter = array('idinteraction'=>$_POST['idinteraction']);
        $data = array();

        $rs = array();
        $rs['sp'] = $l->getTip($filter);


        echo CJSON::encode($rs);
    }
    public function actionPrint() {
	    $interaction = InteractionAR::model()->findByPk($_GET['id']);
        $logic = new InteractionLogic();
        $interaction = $logic->fillDependency($interaction); 
        
        $print = new InteractionPrint();
		$pathToPdf = $print->printInteraction($interaction);
		     
		echo CJSON::encode($pathToPdf);          
    }
    public function actionPrintList() {
        $l = new InteractionLogic();
        $filter = array('limit'=>1000000,'offset'=>0,'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filter($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array(
        		"isrestricted" => $ar['isrestricted'],
                "id" => $ar['idinteraction'],
                "catalognumber1" => $ar['catalognumber1'],
                "scientificname1" => $ar['scientificname1'],
                "catalognumber2" => $ar['catalognumber2'],
                "scientificname2" => $ar['scientificname2'],
                "institution1" => $ar['institutioncode1'],
                "institution2" => $ar['institutioncode2'],
                "collection1" => $ar['collectioncode1'],
                "collection2" => $ar['collectioncode2'],
                "interactiontype" => $ar['interactiontype']
            );
        }
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        
        $print = new InteractionPrint();
		$pathToPdf = $print->printInteractionList($rs);
        
        echo CJSON::encode($pathToPdf);
    }
}

