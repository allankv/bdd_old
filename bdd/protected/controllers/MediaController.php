<?php
include 'logic/MediaLogic.php';
include 'logic/LogLogic.php';

include 'logic/print/MediaPrint.php';

class MediaController extends CController {
    const PAGE_SIZE=10;
    public $defaultAction='goToList';
    public function actionGoToList() {
        $this->render('list', array(
            'related'=>'false',
            ));
    }
    public function actionGoToListRelated() {
        
       $this->renderPartial('list', array(
            'related'=> 'true',
            ));
    }
    public function actionGoToMaintain() {
        if($_GET['id']!=null && MediaAR::model()->findByPk($_GET['id'])!=null) {
            $media = MediaAR::model()->findByPk($_GET['id']);
        }else {
            $media = MediaAR::model();
        }
        $logic = new MediaLogic();
        $media = $logic->fillDependency($media);
        $this->render('maintain',
                array_merge(array(
                'media'=>$media,
                )
        ));
    }
    public function actionGoToShow() {
        if($_GET['id']!=null && MediaAR::model()->findByPk($_GET['id'])!=null) {
            $media = MediaAR::model()->findByPk($_GET['id']);
        }else {
            $media = MediaAR::model();
        }
        $logic = new MediaLogic();
        $media = $logic->fillDependency($media);
        $this->render('show',
                array_merge(array(
                'media'=>$media,
                )
        ));
    }
    public function actionGoToPrint() {
        if($_GET['id']!=null && MediaAR::model()->findByPk($_GET['id'])!=null) {
            $media = MediaAR::model()->findByPk($_GET['id']);
        }else {
            $media = MediaAR::model();
        }
        $logic = new MediaLogic();
        $media = $logic->fillDependency($media);
        $this->renderPartial('print',
                array_merge(array(
                'media'=>$media,
                )
        ));
    }
    public function actionGetMedia() {
        $logic = new MediaLogic();
        $sp = MediaAR::model()->findByPk($_POST['id']);
        $sp = $logic->fillDependency($sp);

        $rs = array();
        $rs['sp'] = $sp->getAttributes();
        $rs['typemedia'] = $sp->typemedia->getAttributes();
        $rs['categorymedia'] =  $sp->categorymedia->getAttributes();

        echo CJSON::encode($rs);
    }
    public function actionSearch() {
        $logic = new MediaLogic();
        $rs = $logic->search($_GET['term']);
        echo CJSON::encode($rs);
    }
    public function actionFilter() {
        $l = new MediaLogic();

        //mediaFilterList = do not show these media records
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list'], 'mediaFilterList'=>$_POST['mediaFilterList']);
        $rs = array();

        $spList = $l->filter($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],//$ar->isrestricted,
                    "id" => $ar['idmedia'],//->idmedia,
                    "title" => $ar['title'],//->title,
                    "typemedia" => $ar['typemedia'],//TypeMediaAR::model()->findByPk($ar->idtypemedia)->typemedia,
                    "categorymedia" => $ar['categorymedia'],//CategoryMediaAR::model()->findByPk($ar->idcategorymedia)->categorymedia,
                    "subtype" => $ar['subtype'],
                    "subcategorymedia" => $ar['subcategorymedia'],
                    "name" => $ar['filesystemname'],
                    "path" => $ar['path'],
                    "size" => $ar['size'],
            );
        }

        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    public function actionShowMedia() {
        $l = new MediaLogic();

        //mediaShowList = show only these media records
        $filter = array('mediaShowList'=>$_POST['mediaShowList']);
        $rs = array();

        $spList = $l->showMedia($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],//$ar->isrestricted,
                    "idmedia" => $ar['idmedia'],//->idmedia,
                    "title" => $ar['title'],//->title,
                    "typemedia" => $ar['typemedia'],//TypeMediaAR::model()->findByPk($ar->idtypemedia)->typemedia,
                    "categorymedia" => $ar['categorymedia'],//CategoryMediaAR::model()->findByPk($ar->idcategorymedia)->categorymedia,
                    "subtype" => $ar['subtype'],
                    "subcategorymedia" => $ar['subcategorymedia'],
                    "name" => $ar['filesystemname'],
                    "path" => $ar['path'],
            );
        }

        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    public function actionSave() {
        $ar = MediaAR::model();
        $ar->setAttributes($_POST['MediaAR'],false);
        $logic = new MediaLogic();
        $rs = $logic->save($ar);
        
        if ($rs['success']) {
            $log = LogAR::model();
            $log->setAttributes(array(
                'iduser'=>Yii::app()->user->id,
                'date'=>date('Y-m-d'),
                'time'=>date('H:i:s'),
                'type'=>substr($rs['operation'],0,-1),
                'module'=>'media',
                'source'=>'form',
                'id'=>$ar->idmedia,
                'transaction'=>null),false);
            $logic = new LogLogic();
            $logmsg = $logic->save($log);        
        }

        echo CJSON::encode($rs);
    }
    public function actionSaveSpecimenNN() {
        $logic = new MediaLogic();
        print_r($_POST);
        if ($_POST['action'] == 'save')
            $logic->saveSpecimenNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpecimenNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionSaveSpeciesNN() {
        $logic = new MediaLogic();
        print_r($_POST);
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionAssociacaoMediaFile(){
    
    	if($_GET['idMedia']!=null && MediaAR::model()->findByPk($_GET['idMedia'])!=null) {
    	
	    	$ar = MediaAR::model()->findByPk($_GET['idMedia']);
	    	$ar->idfile = $_GET['idFile'];
	    	
	    	$logic = new MediaLogic();
	    	$rs = $logic->save($ar);
                $aux[] = 'Successfully created media record titled <b>'.$ar->title.'</b>';
	    	$rs['msg'] = $aux;
	    	echo CJSON::encode($rs);	    	
	    	
    	}
    }
    
    public function actionRemoverMediaFile(){
    
    	if($_GET['idMedia']!=null && MediaAR::model()->findByPk($_GET['idMedia'])!=null) {
    	
	    	$ar = MediaAR::model()->findByPk($_GET['idMedia']);
	    	$ar->idfile = 0;
	    	
	    	$logic = new MediaLogic();
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
            'module'=>'media',
            'source'=>'form',
            'id'=>$_POST['id'],
            'transaction'=>null),false);
        $logic = new LogLogic();
        $logmsg = $logic->save($log);
        
        $logic = new MediaLogic();
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
    
    public function actionPrint() {
	    $media = MediaAR::model()->findByPk($_GET['id']);
        $logic = new MediaLogic();
        $media = $logic->fillDependency($media); 
        
        $print = new MediaPrint();
		$pathToPdf = $print->printMedia($media);
		     
		echo CJSON::encode($pathToPdf);          
    }
    public function actionPrintList() {
        $l = new MediaLogic();

        //mediaFilterList = do not show these media records
        $filter = array('limit'=>1000000,'offset'=>0,'list'=>$_POST['list'], 'mediaFilterList'=>$_POST['mediaFilterList']);
        $rs = array();
        
        
        $spList = $l->filter($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],//$ar->isrestricted,
                    "id" => $ar['idmedia'],//->idmedia,
                    "title" => $ar['title'],//->title,
                    "typemedia" => $ar['typemedia'],//TypeMediaAR::model()->findByPk($ar->idtypemedia)->typemedia,
                    "categorymedia" => $ar['categorymedia'],//CategoryMediaAR::model()->findByPk($ar->idcategorymedia)->categorymedia,
                    "subtype" => $ar['subtype'],
                    "subcategorymedia" => $ar['subcategorymedia'],
                    "name" => $ar['filesystemname'],
                    "path" => $ar['path'],
                    "size" => $ar['size'],
            );
        }

        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        
        $print = new MediaPrint();
		$pathToPdf = $print->printMediaList($rs);
        
        echo CJSON::encode($pathToPdf);
    }
}
