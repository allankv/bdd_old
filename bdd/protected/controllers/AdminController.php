<?php
include 'logic/AdminLogic.php';
include 'logic/LogLogic.php';

class AdminController extends CController
{
	const PAGE_SIZE=10;
	
    public $defaultAction='index';
    
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
    
    public function actionIndex() {
        $this->render('main',array());
    }
    
	public function actionGoToListGroups() {
        $this->render('listGroups',array());
    }
    
	public function actionGoToListUsers() {
        $this->render('listUsers',array());
    }

	public function actionFilterGroups() {
    	
        $l = new AdminLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filterGroups($filter); 
        $list = array();

        if (is_array($spList)){
	        foreach($spList['list'] as $n=>$ar) {
	        		
	        	
		            $list[] = array("id" => $ar['idGroup'],
		                    "name" => $ar['group']
		            );
		        
	        }
        }
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    
	public function actionFilterUsers() {
    	
        $l = new AdminLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filterUsers($filter); 
        $list = array();

        if (is_array($spList)){
	        foreach($spList['list'] as $n=>$ar) {
	        		
	        		$group=groups::model()->findByAttributes(array("idGroup"=>$ar['idGroup']));
	        		
	        		$list[] = array("id" => $ar['idUser'],
		                    "username" => $ar['username'],
		            		"email" => $ar['email'],
		            		"idGroup" => $ar['idGroup'],
		            		"group" => $group->group
		            );
		        
	        }
        }
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    
 	public function actionGroupSearch() {
        $logic = new AdminLogic();
        //$rs = 'teste';
        $rs = $logic->searchGroupList($_GET['term']);
        echo CJSON::encode($rs);
    }
    
	public function actionUserSearch() {
        $logic = new AdminLogic();
        //$rs = 'teste';
        $rs = $logic->searchUserList($_GET['term']);
        echo CJSON::encode($rs);
    }
    
	public function actionDeleteGroup() {
        $users=users::model()->findByAttributes(array("idGroup"=>$_POST['id']));
        
        if ($users == null){
        
	        $logic = new AdminLogic();
	        $return = $logic->deleteGroups($_POST['id']);
	        
	        if ($return==1){
	        	 $log = LogAR::model();
		         $log->setAttributes(array(
		            'iduser'=>Yii::app()->user->id,
		            'date'=>date('Y-m-d'),
		            'time'=>date('H:i:s'),
		            'type'=>'delete',
		            'module'=>'groups',
		            'source'=>'form',
		            'id'=>$_POST['id'],
		            'transaction'=>null),false);
		        $logic = new LogLogic();
		        $logmsg = $logic->save($log);
	        	echo CJSON::encode($return);
	        }
	    }
	    else{
	    	
	    	echo CJSON::encode(-1);
	    }
	}
	
	public function actionDeleteUser() {
       $sp = null;///TO DO
        
        if ($sp == null){
        
	        $logic = new AdminLogic();
	        $return = $logic->deleteUsers($_POST['id']);
	        
	        if ($return==1){
	        	 $log = LogAR::model();
		         $log->setAttributes(array(
		            'iduser'=>Yii::app()->user->id,
		            'date'=>date('Y-m-d'),
		            'time'=>date('H:i:s'),
		            'type'=>'delete',
		            'module'=>'users',
		            'source'=>'form',
		            'id'=>$_POST['id'],
		            'transaction'=>null),false);
		        $logic = new LogLogic();
		        $logmsg = $logic->save($log);
	        	echo CJSON::encode($return);
	        }
	    }
	    else{
	    	
	    	echo CJSON::encode(-1);
	    }
	}
	
	public function actionGoToMaintainGroup() {
        if($_GET['id']!=null && groups::model()->findByPk($_GET['id'])!=null) {
            $ar = groups::model()->findByPk($_GET['id']);
        }else {
            $ar = groups::model();
        }
        
            
        $this->render('maintainGroup',
                array_merge(array(
                'ar'=>$ar,
                )
        ));
    }
    
	public function actionGoToMaintainUser() {
        if($_GET['id']!=null && users::model()->findByPk($_GET['id'])!=null) {
            $ar = users::model()->findByPk($_GET['id']);
            $ar->password = null;
        }else {
            $ar = users::model();
            $ar->password = null;
        }
        
            
        $this->render('maintainUser',
                array_merge(array(
                'ar'=>$ar,
                )
        ));
    }
    
	public function actionSaveGroups() {
  
	if(isset($_POST['groups']))	{
			$ar = groups::model();
        	$ar->setAttributes($_POST['groups'],false);
        	
			$logic = new AdminLogic();
        	$rs = $logic->saveGroups($ar);
        
        if ($rs['success']) {
            $log = LogAR::model();
            $log->setAttributes(array(
                'iduser'=>Yii::app()->user->id,
                'date'=>date('Y-m-d'),
                'time'=>date('H:i:s'),
                'type'=>substr($rs['operation'],0,-1),
                'module'=>'group',
            //    'source'=>'form',
                'id'=>$ar->idGroup,
                'transaction'=>null),false);
            $logic = new LogLogic();
            $logmsg = $logic->save($log);        
        }

        echo CJSON::encode($rs);		
			
				
	}
       

    }
    
	public function actionSaveUsers() {
  
	if(isset($_POST['users']))	{
			$ar = users::model();
        	$ar->setAttributes($_POST['users'],false);
        	
			$logic = new AdminLogic();
        	$rs = $logic->saveUsers($ar);
        
        if ($rs['success']) {
            $log = LogAR::model();
            $log->setAttributes(array(
                'iduser'=>Yii::app()->user->id,
                'date'=>date('Y-m-d'),
                'time'=>date('H:i:s'),
                'type'=>substr($rs['operation'],0,-1),
                'module'=>'user',
            //    'source'=>'form',
                'id'=>$ar->idUser,
                'transaction'=>null),false);
            $logic = new LogLogic();
            $logmsg = $logic->save($log);        
        }

        echo CJSON::encode($rs);		
			
				
	}
       

    }
	
 }
    
		
			
