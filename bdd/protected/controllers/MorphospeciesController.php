<?php
include 'logic/MorphospeciesLogic.php';
include 'SuggestionController.php';
include 'logic/SpecimenLogic.php';
class MorphospeciesController extends SuggestionController
{
    public $defaultAction='goToList';
    public function actionGoToList() {
        $this->render('list',array());
    }
    public function actionGoToListSpecimens() {
        $this->renderPartial('list_specimens',
                array_merge(array(
                'idmorphospecies_child'=>$_GET['idmorphospecies'],
                )));
    }
    public function actionSearch() {
        $rs = $this->logic->search($_GET['term']);
        echo CJSON::encode($rs);
    }
    public function actionFilter() {
        $l = new MorphospeciesLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filter($filter);        
        $list = array();
        //count(*) as n, m.idmorphospecies as id, m.morphospecies as morphospecies
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array(
                   
                    "id" => $ar['id'],//->idmorphospecies,
                    "morphospecies" => $ar['morphospecies'],//occurrenceelements::model()->findByPk($ar->idoccurrenceelements)->catalognumber,
     //scientificnames::model()->findByPk((taxonomicelements::model()->findByPk($ar->idtaxonomicelements)->idscientificname))->scientificname
                    "quantity" => $ar['n']
                   
            );
        }
        
        $rs['result'] = $list;
        $rs['sql'] = $spList['sql'];
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    public function actionIdentify() {
        $this->logic->identify($_POST['idmorphospecies'], $_POST['species'], $_POST['idspecies'], $_POST['valid']);
    }
    public function actionIdentifychild() {
        $this->logic->identify_child($_POST['idmorphospecies'], $_POST['species'], $_POST['idspecies'], $_POST['valid'], $_POST['idtaxonomicelement']);  
    }
    public function actionFilterchild() {
        $l = new MorphospeciesLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list'], 'idmorphospecies'=>$_POST['idmorphospecies']);
        $rs = array();
        
        $spList = $l->filter_child($filter);        
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array(
                    "idmorphospecies" => $_POST['idmorphospecies'],
                    "id" => $ar["id"], // id pode ser do idspecimen ou idmonitoring
                    "morphospecies" => $ar["morphospecies"],
                    "idtaxonomicelement" => $ar['idtaxonomicelement'],
                    "collectioncode" => $ar['collectioncode'],
                    "catalognumber" => $ar['catalognumber'],
                    "institutioncode" => $ar['institutioncode'],
                    "controller" => $ar['controller']
            );
        }
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'];
        //$rs['count'] = $spList['count'][0]['count'];
        //$rs['sql'] = $spList['sql'];
        echo CJSON::encode($rs);
    }
    
    public function actionSearchLocal() {
        $logic = new MorphospeciesLogic();
        $rs = array();        
		$rs = $logic->searchLocal($_GET['term'],5, false);
        echo CJSON::encode($rs);
    }
    
    public function actionSearchCol() {
    	$l = new MorphospeciesLogic();
        $q = $_POST['scientificname'];
        $rs = array();
	    $rs = $l->searchCol($q);
	    echo CJSON::encode($rs);
    }
    
    public function actionSearchColEqual() {
    	$l = new MorphospeciesLogic();
        $q = $_POST['scientificname'];
        $rs = array();
	    $rs = $l->searchColEqual($q);
	    echo CJSON::encode($rs);
    }
    
   /* public function filters() {
        //Personalize parameters
        $this->logic = new MorphospeciesLogic();
        //Call parent function
        parent::filters();
    }*/
    
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
}
