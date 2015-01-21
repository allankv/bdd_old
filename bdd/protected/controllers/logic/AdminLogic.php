<?php

class AdminLogic {
	 
     var $mainAtt = '"group"';
     var $mainAtt2 = '"username"';
     
	public function filterGroups($filter) {
            $c = array();
            $rs = array();
			$criteria = '1 = 1 ';
			        	
	        $c['select'] = 'SELECT "idGroup", "group"';
	        $c['from'] = ' FROM groups g ';
	        if($filter['list']!=null) {
            	foreach ($filter['list'] as &$v) {
		            	if($v['controller']=='Group') {
		                    //$groupWhere = $groupWhere==''?'':$groupWhere.' OR ';
		                    $groupWhere = ' and  g."idGroup" = '.$v['id'];
		                }
           		 }
	          }
		    $c['where'] = ' WHERE '.$criteria.$groupWhere;
	        
		    
		    //$c['option'] = ' and sp.idspecimen in (104,107, 44, 7, 57,40,66,68,69,65) ';
	        $c['orderby'] = ' ORDER BY g.group ';
	        
	        if ($filter['limit']!=null){
	       		 $c['limit'] = ' limit '.$filter['limit'];
	        	 $c['offset'] = ' offset '.$filter['offset'];
	        }
	
	        // junta tudo
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['option'].$c['orderby'].$c['limit'].$c['offset'];

	        //print $sql;
	      //  exit;
	        // faz consulta e manda para list
	        $rs['list'] = WebbeeController::executaSQL($sql);
	        // altera parametros de consulta para fazer o Count
	        $c['select'] = 'SELECT count(*) ';
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
	        // faz consulta do Count e manda para count
	        //$rs['script'] = $sql;
	        $rs['count'] = WebbeeController::executaSQL($sql);
	        
	        
        
        
        return $rs;
    }
    
	public function filterUsers($filter) {
            $c = array();
            $rs = array();
			$criteria = '1 = 1 ';
			        	
	        $c['select'] = 'SELECT "idUser", "username", "email", "idGroup"';
	        $c['from'] = ' FROM users u ';
	        if($filter['list']!=null) {
            	foreach ($filter['list'] as &$v) {
		            	if($v['controller']=='User') {
		                    //$groupWhere = $groupWhere==''?'':$groupWhere.' OR ';
		                    $groupWhere = ' and  u."idUser" = '.$v['id'];
		                }
           		 }
	          }
		    $c['where'] = ' WHERE '.$criteria.$groupWhere;
	        
		    
		    //$c['option'] = ' and sp.idspecimen in (104,107, 44, 7, 57,40,66,68,69,65) ';
	        $c['orderby'] = ' ORDER BY u.username ';
	        
	        if ($filter['limit']!=null){
	       		 $c['limit'] = ' limit '.$filter['limit'];
	        	 $c['offset'] = ' offset '.$filter['offset'];
	        }
	
	        // junta tudo
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['option'].$c['orderby'].$c['limit'].$c['offset'];

	        //print $sql;
	      //  exit;
	        // faz consulta e manda para list
	        $rs['list'] = WebbeeController::executaSQL($sql);
	        // altera parametros de consulta para fazer o Count
	        $c['select'] = 'SELECT count(*) ';
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
	        // faz consulta do Count e manda para count
	        //$rs['script'] = $sql;
	        $rs['count'] = WebbeeController::executaSQL($sql);
	        
	        
        
        
        return $rs;
    }

 public function searchGroup($q) {
        $ar = groups::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
 }
    
public function searchGroupList($q) {

        $groupList = $this->searchGroup($q);
        $rs = array();

        //Main fields

        foreach($groupList as $n=>$ar) {
            $rs[] = array("controller" => "Group","id" => $ar->idGroup,"label" => $ar->group,"category" => "Users Group");
        }
        



        return $rs;
    }
 

public function deleteGroups($id) {
          
       $ar=groups::model()->findByPk($id); 
	   $ar->delete(); 
        
       return 1;
    }



public function saveGroups($ar) {
        $ar->modified=date('Y-m-d G:i:s');
             
        $rs = array ();
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idGroup == null?'created':'updated';
            $ar->setIsNewRecord($rs['operation']=='created');
            $aux = array();
            $aux[] = 'Successfully '.$rs['operation'].' group record titled '.$ar->group;
            $rs['msg'] = $aux;
            $ar->idGroup = $ar->getIsNewRecord()?null:$ar->idGroup;
            $ar->save();
            $rs['id'] = $ar->idGroup;
            return $rs;
        }else {
            $erros = array ();
            foreach($ar->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            $rs['success'] = false;
            $rs['msg'] = $erros;
            return $rs;
        }
    }

public function saveUsers($ar) {
        $ar->modified=date('Y-m-d G:i:s');
        $ar->password = md5($ar->password);
        $rs = array ();
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idUser == null?'created':'updated';
            $ar->setIsNewRecord($rs['operation']=='created');
            $aux = array();
            $aux[] = 'Successfully '.$rs['operation'].' user record titled '.$ar->username;
            $rs['msg'] = $aux;
            $ar->idUser = $ar->getIsNewRecord()?null:$ar->idUser;
            $ar->save();
            $rs['id'] = $ar->idUser;
            return $rs;
        }else {
            $erros = array ();
            foreach($ar->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            $rs['success'] = false;
            $rs['msg'] = $erros;
            return $rs;
        }
    }
public function searchUser($q) {
        $ar = users::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt2 ilike '%$q%' OR difference($this->mainAtt2, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt2";
        $rs = $ar->findAll($criteria);
        return $rs;
 }
    
public function searchUserList($q) {

        $groupList = $this->searchUser($q);
        $rs = array();

        //Main fields

        foreach($groupList as $n=>$ar) {
            $rs[] = array("controller" => "User","id" => $ar->idUser,"label" => $ar->username,"category" => "Users");
        }
        



        return $rs;
    }
 

public function deleteUsers($id) {
          
       $ar=users::model()->findByPk($id); 
	   $ar->delete(); 
        
       return 1;
    }
    

}
?>
