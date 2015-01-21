<?php
include 'logic/SpeciesLogic.php';
include 'logic/LogLogic.php';

include 'logic/print/SpeciesPrint.php';


class SpeciesController extends CController
{
    public $defaultAction='goToList';
    public function actionGoToList() {
        $this->render('list',array());
    }
    public function actionGoToMaintain() {
        if($_GET['id']!=null && SpeciesAR::model()->findByPk($_GET['id'])!=null) {
            $spc = SpeciesAR::model()->findByPk($_GET['id']);
        }else {
            $spc = SpeciesAR::model();
        }
        $logic = new SpeciesLogic();
        $spc = $logic->fillDependency($spc);
        $this->render('maintain',
                array_merge(array(
                'spc'=>$spc,
                )
        ));
    }
    public function actionGoToShow() {
        if($_GET['id']!=null && SpeciesAR::model()->findByPk($_GET['id'])!=null) {
            $spc = SpeciesAR::model()->findByPk($_GET['id']);
        }else {
            $spc = SpeciesAR::model();
        }
        $logic = new SpeciesLogic();
        $spc = $logic->fillDependency($spc);
        $this->render('show',
                array_merge(array(
                'spc'=>$spc,
                )
        ));
    }
    public function actionGoToPrint() {
        if($_GET['id']!=null && SpeciesAR::model()->findByPk($_GET['id'])!=null) {
            $spc = SpeciesAR::model()->findByPk($_GET['id']);
        }else {
            $spc = SpeciesAR::model();
        }
        $logic = new SpeciesLogic();
        $spc = $logic->fillDependency($spc);
        $this->renderPartial('print',
                array_merge(array(
                'spc'=>$spc,
                )
        ));
    }
    /*
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
    }*/
    public function actionSearch() {
        $logic = new SpeciesLogic();
        $rs = $logic->search($_GET['term']);
        echo CJSON::encode($rs);
    }
    public function actionFilter() {
        $l = new SpeciesLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filter($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],//$ar->isrestricted,
                    "id" => $ar['idspecies'],//->idspecies,
                    "scientificname" => $ar['scientificname'],//scientificnames::model()->findByPk((taxonomicelements::model()->findByPk($ar->idtaxonomicelements)->idscientificname))->scientificname
                    "institutioncode" => $ar['institutioncode']
            );
        }

        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    public function actionSave() {
        $sp = SpeciesAR::model();
        //if($_POST['SpeciesAR']['idspecies']!='') {
            $sp->setAttributes($_POST['SpeciesAR'],false);
        //}

        $logic = new TaxonomicElementLogic();
        $sp->taxonomicelement = $logic->setAttributes($_POST['TaxonomicElementAR']);
        
        $logic = new SpeciesLogic();
        $rs = $logic->save($sp);
        
        if ($rs['success']) {
            $log = LogAR::model();
            $log->setAttributes(array(
                'iduser'=>Yii::app()->user->id,
                'date'=>date('Y-m-d'),
                'time'=>date('H:i:s'),
                'type'=>substr($rs['operation'],0,-1),
                'module'=>'species',
                'source'=>'form',
                'id'=>$sp->idspecies,
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
            'module'=>'species',
            'source'=>'form',
            'id'=>$_POST['id'],
            'transaction'=>null),false);
        $logic = new LogLogic();
        $logmsg = $logic->save($log);
        
        $logic = new SpeciesLogic();
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
    /*
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

    }*/
    public function actionGetTip()
    {
        $l = new SpeciesLogic();
        $filter = array('idspecies'=>$_POST['idspecies']);
        $data = array();

        $rs = array();
        $rs['sp'] = $l->getTip($filter);


        echo CJSON::encode($rs);
    }
    public function actionGetRelatedMedia()
    {
        $l = new SpeciesLogic();
        $filter = array('idspecies'=>$_POST['idspecies']);
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
        $l = new SpeciesLogic();
        $filter = array('idspecies'=>$_POST['idspecies'], 'idmedia'=>$_POST['idmedia']);

        $l->removeMedia($filter);

    }
    public function actionGetReference()
    {
        $l = new SpeciesLogic();
        $filter = array('idspecies'=>$_POST['idspecies']);
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
        $l = new SpeciesLogic();
        $filter = array('idspecies'=>$_POST['idspecies'], 'idreference'=>$_POST['idreference']);

        $l->removeReference($filter);

    }
    public function actionGetPubReference()
    {
        $l = new SpeciesLogic();
        $filter = array('idspecies'=>$_POST['idspecies']);
        $rs = array();

        $spList = $l->getPubReference($filter);
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
    public function actionRemovePubReference()
    {
        $l = new SpeciesLogic();
        $filter = array('idspecies'=>$_POST['idspecies'], 'idreference'=>$_POST['idreference']);

        $l->removePubReference($filter);

    }
    public function actionGetPaper()
    {
        $l = new SpeciesLogic();
        $filter = array('idspecies'=>$_POST['idspecies']);
        $rs = array();

        $spList = $l->getPaper($filter);
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
    public function actionRemovePaper()
    {
        $l = new SpeciesLogic();
        $filter = array('idspecies'=>$_POST['idspecies'], 'idreference'=>$_POST['idreference']);

        $l->removePaper($filter);

    }
    public function actionGetKey()
    {
        $l = new SpeciesLogic();
        $filter = array('idspecies'=>$_POST['idspecies']);
        $rs = array();

        $spList = $l->getKey($filter);
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
    public function actionRemoveKey()
    {
        $l = new SpeciesLogic();
        $filter = array('idspecies'=>$_POST['idspecies'], 'idreference'=>$_POST['idreference']);

        $l->removeKey($filter);

    }
    public function actionPrint() {
	    $spc = SpeciesAR::model()->findByPk($_GET['id']);
        $logic = new SpeciesLogic();
        $spc = $logic->fillDependency($spc); 
        
        $print = new SpeciesPrint();
		$pathToPdf = $print->printSpecies($spc);
		     
		echo CJSON::encode($pathToPdf);          
    }
    public function actionPrintList() {
        $l = new SpeciesLogic();
        $filter = array('limit'=>1000000,'offset'=>0,'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filter($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array(
	    		"isrestricted" => $ar['isrestricted'],
	            "id" => $ar['idspecies'],
	            "scientificname" => $ar['scientificname'],
	            "institutioncode" => $ar['institutioncode']
            );
        }

        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        
        $print = new SpeciesPrint();
		$pathToPdf = $print->printSpeciesList($rs);
        
        echo CJSON::encode($pathToPdf);
    }
}
