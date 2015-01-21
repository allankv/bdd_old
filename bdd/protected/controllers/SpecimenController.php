<?php
include 'logic/SpecimenLogic.php';
include 'logic/LogLogic.php';

include 'logic/print/SpecimenPrint.php';

class SpecimenController extends CController {
    const PAGE_SIZE=10;
    public $defaultAction='goToList';
    public function actionGoToList() {
        $this->render('list',array());
    }
    public function actionGoToMaintain() {
        if($_GET['id']!=null && SpecimenAR::model()->findByPk($_GET['id'])!=null) {
            $spm = SpecimenAR::model()->findByPk($_GET['id']);
        }else {
            $spm = SpecimenAR::model();
        }
        $logic = new SpecimenLogic();
        $spm = $logic->fillDependency($spm);                
        $this->render('maintain',
                array_merge(array(
                'spm'=>$spm,
                )
        ));
    }
    public function actionGoToShow() {
        if($_GET['id']!=null && SpecimenAR::model()->findByPk($_GET['id'])!=null) {
            $spm = SpecimenAR::model()->findByPk($_GET['id']);
        }else {
            $spm = SpecimenAR::model();
        }
        $logic = new SpecimenLogic();
        $spm = $logic->fillDependency($spm);           
        $this->render('show',
                array_merge(array(
                'spm'=>$spm,
                )
        ));
    }
    public function actionGoToPrint() {
        if($_GET['id']!=null && SpecimenAR::model()->findByPk($_GET['id'])!=null) {
            $spm = SpecimenAR::model()->findByPk($_GET['id']);
        }else {
            $spm = SpecimenAR::model();
        }
        $logic = new SpecimenLogic();
        $spm = $logic->fillDependency($spm);                
        $this->renderPartial('print',
                array_merge(array(
                'spm'=>$spm,
                )
        ));
    }
    public function actionGoToPrintList() {
        $logic = new SpecimenLogic();
        $spm = $logic->fillDependency($spm);                
        $this->renderPartial('printlist',
                array_merge(array(
                'spm'=>$spm,
                )
        ));
    }
    public function actionGetSpecimen() {
        $logic = new SpecimenLogic();
        $sp = SpecimenAR::model()->findByPk($_POST['id']);
        $sp = $logic->fillDependency($sp);

        $rs = array();
        $rs['sp'] = $sp->getAttributes();
        $rs['institutionCode'] = $sp->recordlevelelement->institutioncode->getAttributes();
        $rs['collectionCode'] =  $sp->recordlevelelement->collectioncode->getAttributes();
        $rs['occurrenceElement'] =  $sp->occurrenceelement->getAttributes();
        $rs['scientificName'] =  $sp->taxonomicelement->scientificname->getAttributes();

        echo CJSON::encode($rs);
    }
    public function actionSearch() {
        $logic = new SpecimenLogic();
        $rs = $logic->search($_GET['term']);
        echo CJSON::encode($rs);
    }
    public function actionFilter() {
        $l = new SpecimenLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filter($filter);        
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],//$ar->isrestricted,
                    "id" => $ar['idspecimen'],//->idspecimen,
                    "catalognumber" => $ar['catalognumber'],//occurrenceelements::model()->findByPk($ar->idoccurrenceelements)->catalognumber,
     //scientificnames::model()->findByPk((taxonomicelements::model()->findByPk($ar->idtaxonomicelements)->idscientificname))->scientificname
                    "institution" => $ar['institutioncode'],
                    "collection" => $ar['collectioncode'],
                    "kingdom" => $ar['kingdom'],
	            	"phylum" => $ar['phylum'],
	            	"class" => $ar['class'],
	            	"order" => $ar['order'],
	            	"family" => $ar['family'],
	            	"genus" => $ar['genus'],
	            	"subgenus" => $ar['subgenus'],
	            	"specificepithet" => $ar['specificepithet'],
	            	"infraspecificepithet" => $ar['infraspecificepithet'],
	            	"scientificname" => $ar['scientificname']
            );
        }
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    public function actionSave() {
        $sp = SpecimenAR::model();
        if($_POST['SpecimenAR']['idspecimen']!='') {
            $sp->setAttributes($_POST['SpecimenAR'],false);
        }
        $logic = new RecordLevelElementLogic();
        $sp->recordlevelelement = $logic->setAttributes($_POST['RecordLevelElementAR']);
        $logic = new OccurrenceElementLogic();
        $sp->occurrenceelement = $logic->setAttributes($_POST['OccurrenceElementAR']);
        $logic = new CuratorialElementLogic();
        $sp->curatorialelement = $logic->setAttributes($_POST['CuratorialElementAR']);
        $logic = new IdentificationElementLogic();
        $sp->identificationelement = $logic->setAttributes($_POST['IdentificationElementAR']);
        $logic = new EventElementLogic();
        $sp->eventelement = $logic->setAttributes($_POST['EventElementAR']);
        $logic = new TaxonomicElementLogic();
        $sp->taxonomicelement = $logic->setAttributes($_POST['TaxonomicElementAR']);
        $logic = new LocalityElementLogic();
        $sp->localityelement = $logic->setAttributes($_POST['LocalityElementAR']);
        $logic = new GeospatialElementLogic();
        $sp->geospatialelement = $logic->setAttributes($_POST['GeospatialElementAR']);

        $logic = new SpecimenLogic();
        $rs = $logic->save($sp);
        
        if ($rs['success']) {
            $log = LogAR::model();
            $log->setAttributes(array(
                'iduser'=>Yii::app()->user->id,
                'date'=>date('Y-m-d'),
                'time'=>date('H:i:s'),
                'type'=>substr($rs['operation'],0,-1),
                'module'=>'specimen',
                'source'=>'form',
                'id'=>$sp->idspecimen,
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
            'module'=>'specimen',
            'source'=>'form',
            'id'=>$_POST['id'],
            'transaction'=>null),false);
        $logic = new LogLogic();
        $logmsg = $logic->save($log);
        
        $logic = new SpecimenLogic();
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
    public function actionGetRelatedMedia()
    {
        $l = new SpecimenLogic();
        $filter = array('idspecimen'=>$_POST['idspecimen']);
        $rs = array();

        $spList = $l->getMedia($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("idmedia" => $ar['idmedia']);
        }

        $rs['result'] = $list;
        echo CJSON::encode($rs);
    }
    public function actionRemoveMedia()
    {
        $l = new SpecimenLogic();
        $filter = array('idspecimen'=>$_POST['idspecimen'], 'idmedia'=>$_POST['idmedia']);

        $l->removeMedia($filter);

    }
    public function actionGetReference()
    {
        $l = new SpecimenLogic();
        $filter = array('idspecimen'=>$_POST['idspecimen']);
        $rs = array();

        $spList = $l->getReference($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("title" => $ar['title'],
                    "idreference" => $ar['idreferenceelement'],
                    "categoryreference" => $ar['categoryreference'],
                    "subcategoryreference" => $ar['subcategoryreference'],
                    "source" => $ar['source'],
                    "isrestricted" => $ar['isrestricted'],
                    "typereference" => $ar['typereference'],
            );
        }

        $rs['result'] = $list;
        echo CJSON::encode($rs);
    }
    public function actionRemoveReference()
    {
        $l = new SpecimenLogic();
        $filter = array('idspecimen'=>$_POST['idspecimen'], 'idreference'=>$_POST['idreference']);

        $l->removeReference($filter);

    }
    public function actionGetTip()
    {
        $l = new SpecimenLogic();
        $filter = array('idspecimen'=>$_POST['idspecimen']);
        $data = array();

        $rs = array();
        $rs['sp'] = $l->getTip($filter);


        echo CJSON::encode($rs);
    }
    public function actionPrint() {
	    $spm = SpecimenAR::model()->findByPk($_GET['id']);
        $logic = new SpecimenLogic();
        $spm = $logic->fillDependency($spm); 
        
        $print = new SpecimenPrint();
		$pathToPdf = $print->printSpecimen($spm);
		     
		echo CJSON::encode($pathToPdf);          
    }
    public function actionPrintList() {
    
        $l = new SpecimenLogic();
        $filter = array('limit'=>1000000,'offset'=>0,'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filter($filter);       
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],
                    "id" => $ar['idspecimen'],
                    "catalognumber" => $ar['catalognumber'],
                    "institution" => $ar['institutioncode'],
                    "collection" => $ar['collectioncode'],
                    "kingdom" => $ar['kingdom'],
	            	"phylum" => $ar['phylum'],
	            	"class" => $ar['class'],
	            	"order" => $ar['order'],
	            	"family" => $ar['family'],
	            	"genus" => $ar['genus'],
	            	"subgenus" => $ar['subgenus'],
	            	"specificepithet" => $ar['specificepithet'],
	            	"infraspecificepithet" => $ar['infraspecificepithet'],
	            	"scientificname" => $ar['scientificname']
            );
        }
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        
        $print = new SpecimenPrint();
		$pathToPdf = $print->printSpecimenList($rs);
        
        echo CJSON::encode($pathToPdf);
    }
}
