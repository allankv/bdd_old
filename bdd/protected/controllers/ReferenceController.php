<?php
include 'logic/ReferenceLogic.php';
include 'logic/LogLogic.php';

include 'logic/print/ReferencePrint.php';

class ReferenceController extends CController {
    const PAGE_SIZE=10;
    public $defaultAction='goToList';
    public function actionGoToList() {
        $this->render('list',array(
            'related'=>'no',
        ));
    }
    public function actionGetXml() {
        $logic = new ReferenceLogic();    	
        $this->render('getXML',array(
            'address'=>$logic->getXml(),
        ));
    }
    public function actionGoToListRelated() {
        $this->renderPartial('list',array(
            'related'=>'ref',
        ));
    }
    public function actionGoToListRelatedPub() {
        $this->renderPartial('list',array(
            'related'=>'pub',
        ));
    }
    public function actionGoToListRelatedPaper() {
        $this->renderPartial('list',array(
            'related'=>'paper',
        ));
    }
    public function actionGoToListRelatedKey() {
        $this->renderPartial('list',array(
            'related'=>'key',
        ));
    }
    public function actionGoToMaintain() {
        if($_GET['id']!=null && ReferenceAR::model()->findByPk($_GET['id'])!=null) {
            $reference = ReferenceAR::model()->findByPk($_GET['id']);
        }else {
            $reference = ReferenceAR::model();
        }
        $logic = new ReferenceLogic();
        $reference = $logic->fillDependency($reference);
        $this->render('maintain',
                array_merge(array(
                'reference'=>$reference,
                )
        ));
    }
    public function actionGoToShow() {
        if($_GET['id']!=null && ReferenceAR::model()->findByPk($_GET['id'])!=null) {
            $reference = ReferenceAR::model()->findByPk($_GET['id']);
        }else {
            $reference = ReferenceAR::model();
        }
        $logic = new ReferenceLogic();
        $reference = $logic->fillDependency($reference);
        $this->render('show',
                array_merge(array(
                'reference'=>$reference,
                )
        ));
    }
    public function actionGoToPrint() {
        if($_GET['id']!=null && ReferenceAR::model()->findByPk($_GET['id'])!=null) {
            $reference = ReferenceAR::model()->findByPk($_GET['id']);
        }else {
            $reference = ReferenceAR::model();
        }
        $logic = new ReferenceLogic();
        $reference = $logic->fillDependency($reference);
        $this->renderPartial('print',
                array_merge(array(
                'reference'=>$reference,
                )
        ));
    }
    public function actionSearch() {
        $logic = new ReferenceLogic(); 
        $rs = $logic->search($_GET['term']);
        echo CJSON::encode($rs);
    }
    public function actionFilter() {
        $l = new ReferenceLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list'], 'refFilterList'=>$_POST['refFilterList']);
        $rs = array();

        $spList = $l->filter($filter);
        $list = array();
        
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],//$ar->isrestricted,
                    "idreference" => $ar['idreferenceelement'],//->idreferenceelement,
                    "title" => $ar['title'],//->title,
                    "subtypereference" => $ar['subtypereference'],//TypeReferenceAR::model()->findByPk($ar->idtypereference)->typereference,
                    "categoryreference" => $ar['categoryreference'],//CategoryReferenceAR::model()->findByPk($ar->idcategoryreference)->categoryreference,
                    "subcategoryreference" => $ar['subcategoryreference'],
                    "file" => $ar['filesystemname'],
                    "path" => $ar['path'],

                );
        }

        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    public function actionShowReference() {
        $l = new ReferenceLogic();

        //refShowList = show only these ref records
        $filter = array('refShowList'=>$_POST['refShowList']);
        $rs = array();

        $spList = $l->showReference($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],//$ar->isrestricted,
                    "idreference" => $ar['idreferenceelement'],//->idreferenceelement,
                    "title" => $ar['title'],//->title,
                    "subtypereference" => $ar['subtypereference'],//TypeReferenceAR::model()->findByPk($ar->idtypereference)->typereference,
                    "categoryreference" => $ar['categoryreference'],//CategoryReferenceAR::model()->findByPk($ar->idcategoryreference)->categoryreference,
                    "subcategoryreference" => $ar['subcategoryreference'],
                    "file" => $ar['filesystemname'],
                    "path" => $ar['path'],
                );
        }

        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    public function actionSave() {
        $ar = ReferenceAR::model();
        $ar->setAttributes($_POST['ReferenceAR'],false);
        $logic = new ReferenceLogic();
        $rs = $logic->save($ar);
        
        if ($rs['success']) {
            $log = LogAR::model();
            $log->setAttributes(array(
                'iduser'=>Yii::app()->user->id,
                'date'=>date('Y-m-d'),
                'time'=>date('H:i:s'),
                'type'=>substr($rs['operation'],0,-1),
                'module'=>'reference',
            //    'source'=>'form',
                'id'=>$ar->idreferenceelement,
                'transaction'=>null),false);
            $logic = new LogLogic();
            $logmsg = $logic->save($log);        
        }

        echo CJSON::encode($rs);
    }
    public function actionSaveSpecimenNN() {
        $logic = new ReferenceLogic();
        print_r($_POST);
        if ($_POST['action'] == 'save')
            $logic->saveSpecimenNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpecimenNN($_POST['idItem'], $_POST['idElement']);
    }

    public function actionSaveSpeciesNN() {
        $logic = new ReferenceLogic();
            if($_POST['action']=='save')
                $logic->saveSpeciesNN($_POST['idItem'],$_POST['idElement']);
            else if($_POST['action']=='delete')
                $logic->deleteSpeciesNN($_POST['idItem'],$_POST['idElement']);
    }
    
    public function actionAssociacaoReferenceFile(){
    
    	if($_GET['idReference']!=null && ReferenceAR::model()->findByPk($_GET['idReference'])!=null) {
    	
	    	$ar = ReferenceAR::model()->findByPk($_GET['idReference']);
	    	$ar->idfile = $_GET['idFile'];
	    	
	    	$logic = new ReferenceLogic();
	    	$rs = $logic->save($ar);    	
	    	$aux[] = 'Successfully created reference record titled <b>'.$ar->title.'</b>';
	    	$rs['msg'] = $aux;
	    	echo CJSON::encode($rs);	    	
	    	
    	}
    }
    
    public function actionRemoverReferenceFile(){
    
    	if($_GET['idReference']!=null && ReferenceAR::model()->findByPk($_GET['idReference'])!=null) {
    	
	    	$ar = ReferenceAR::model()->findByPk($_GET['idReference']);
	    	$ar->idfile = null;
	    	
	    	$logic = new ReferenceLogic();
	    	$rs = $logic->save($ar);    	
	    	
	    	echo CJSON::encode($rs);    	
	    	
    	}
    }     
    
    
    public function actionDelete() {
        $log = LogAR::model();
        $log->setAttributes(array(
            'iduser'=>Yii::app()->user->id,
            'date'=>date('Y-m-d'),
            'time'=>date('H:i:s'),
            'type'=>'delete',
            'module'=>'reference',
           // 'source'=>'form',
            'id'=>$_POST['id'],
            'transaction'=>null),false);
        $logic = new LogLogic();
        $logmsg = $logic->save($log);
        
        $logic = new ReferenceLogic();
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
        $l = new ReferenceLogic();
        $filter = array('idreference'=>$_POST['idreference']);
        $data = array();

        $rs = array();
        $rs['sp'] = $l->getTip($filter);


        echo CJSON::encode($rs);
    }
    public function actionPrint() {
	    $reference = ReferenceAR::model()->findByPk($_GET['id']);
        $logic = new ReferenceLogic();
        $reference = $logic->fillDependency($reference); 
        
        $print = new ReferencePrint();
		$pathToPdf = $print->printReference($reference);
		echo CJSON::encode($pathToPdf);          
    }
    public function actionPrintList() {
        $l = new ReferenceLogic();
        $filter = array('limit'=>1000000, 'offset'=>0,'list'=>$_POST['list'], 'refFilterList'=>$_POST['refFilterList']);
        $rs = array();

        $spList = $l->filter($filter);
        $list = array();
        
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array(
        		"isrestricted" => $ar['isrestricted'],
                "idreference" => $ar['idreferenceelement'],
                "title" => $ar['title'],
                "subtypereference" => $ar['subtypereference'],
                "categoryreference" => $ar['categoryreference'],
                "subcategoryreference" => $ar['subcategoryreference'],
                "file" => $ar['filesystemname'],
                "path" => $ar['path'],
                "bibliographiccitation" => $ar['bibliographiccitation'],
            );
        }

        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];

        $print = new ReferencePrint();
		$pathToPdf = $print->printReferenceList($rs);
        
        echo CJSON::encode($pathToPdf);
    }
}
