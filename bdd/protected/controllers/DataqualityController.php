<?php
include 'logic/SpecimenLogic.php';
include 'logic/DataqualityLogic.php';
include_once 'logic/GeospatialElementLogic.php';
include_once 'logic/TaxonRankLogic.php';


class DataqualityController extends CController
{
const PAGE_SIZE=10;
    public $defaultAction='goToList';
    public function actionGoToList() {
        $this->render('main',array());
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

	public function actionLogSearch(){
		    $id_specimen = (int) $_POST['id_specimen'];
   		 	$idDQ = (int) $_POST['idDQ'];
		    $log_dqAR = Log_dqAR::model()->findByAttributes(
		    array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ));
		    if ($log_dqAR != null){
		    	$result = 1;
		    	echo CJSON::encode($result);
		    }
		    else {
		    	$result = -1;
		    	echo CJSON::encode($result);
		    }
				
	}
	
	
	public function actionShowButtonReturn(){
		    $id_specimen = (int) $_POST['id_specimen'];
   		 	$idDQ = $_POST['idDQ'];
		    $log_dqAR = Log_dqAR::model()->findByAttributes(array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ ,'undo_log' => null));
		    
			
		    
		    
		    if ($log_dqAR != null){ //pode aparecer o botao
		    	$result = 1;
		    	echo CJSON::encode($result);
		    }
		    else {
		    	$result = 0; //nao pode aparecer o botao
		    	echo CJSON::encode($result);
		    }
				
	}
	
	public function LogSearchUpdate($id_specimen,$idDQ){
		   
		    $log_dqAR = Log_dqAR::model()->findByAttributes(
		    array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ));
		    if ($log_dqAR != null){
		    	return $result = 1;
		    	//echo CJSON::encode($result);
		    }
		    else {
		    	return $result = 0;
		    	//echo CJSON::encode($result);
		    }
				
	}
	public function LogUpdate($id_specimen,$idDQ){
		    
			$id_specimen = $id_specimen;
			$log_type = $idDQ;
			
			$log_dqAR = Log_dqAR::model()->findByAttributes(
		    	array('id_specimen'=>$id_specimen,'id_type_log'=>$log_type,'undo_log'=>null));
		    
		     $id_log_dq = $log_dqAR->id;
		           	
           	 $logUndoReturn=Log_dqAR::model()->updateByPk($id_log_dq,array('undo_log'=>1, 'date_update'=>date('Y-m-d'),'time_update'=>date('H:i:s')));
           	 
		
	}
    public function LogInsert($id_specimen, $log_type,$log_dq_delete_items_id){
		    $log_dq = new Log_dqAR();
            $log_dq->id_user = Yii::app()->user->id;
            $log_dq->date_update = date('Y-m-d');
            $log_dq->time_update = date('H:i:s');
            $log_dq->id_type_log = $log_type;
            $log_dq->id_specimen=(int) $id_specimen;
            $log_dq->id_log_dq_deleted_items = (int) $log_dq_delete_items_id;
            
           	$log_dq->save();
           	return $log_dq->id;
		
	}
	public function UpdateModifyRecordlevelelement($id_specimen){
		
		
		$sp=SpecimenAR::model()->with('recordlevelelement')->findbyPK($id_specimen);
   		$idRecordlevelelement = $sp->idrecordlevelelement;
   		$data=date('Y-m-d H:m:s');
   		$date_modified=RecordlevelelementAR::model()->updateByPk($idRecordlevelelement,array('modified'=>$data));
   		
   		return $date_modified;
   		
	} 
	
	
	
	public function actionUndoCorrections(){
			
			$trans = Yii::app()->db->beginTransaction();
			$id_specimen = $_POST['id_specimen'];
			$idDQ = $_POST['idDQ'];
			$sp=SpecimenAR::model()->with('localityelement')->findbyPK($id_specimen);
   			$idGeoSpElement = $sp->idgeospatialelement;
   			$idLocElement = $sp->idlocalityelement;
   			
			//buscar log de alteração da especie
			
			$log_dqAR = Log_dqAR::model()->findByAttributes(
		    	array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ,'undo_log'=>null));
		    
		     $id_log_dq = $log_dqAR->id;

		     //buscar fields de alteracao
		     $log_dq_fields = Log_dq_fieldsAR::model()->findAllByAttributes(array('id_log_dq'=>$id_log_dq));
		    
		     //print_r($id_log_dq);
		    // exit;

		    //buscar valores no log
		    
		    if ($idDQ == 1){
		    	 $latitude = null;
		    	 $longitude = null;
		    	 $georeferenceremark = '';
		    	 
		    	foreach ($log_dq_fields as $logf){
			 	 	if ($logf['field_name']=='latitude') {
			 	 		$latitude = $logf['field_value'] == 0?null:(float) $logf['field_value'];
			 	 	}
		    		else if ($logf['field_name']=='longitude') {
			 	 		$longitude = $logf['field_value'] == 0?null:(float) $logf['field_value'];
			 	 	}
			 	 	else if ($logf['field_name']=='georeferenceremark') {
			 	 		$georeferenceremark = $logf['field_value'];
			 	 	}
			    }
			    
			    //alterar tabela
			    $geoUndoReturn=GeospatialElementAR::model()->updateByPk($idGeoSpElement,array('decimallongitude'=>$longitude,
	   		 														'decimallatitude'=>$latitude,'georeferenceremark'=>$georeferenceremark));
			    
		    	
			   
			    if ($geoUndoReturn==1){
			    	
			    	//grava 'no' nos items deletados
			    	
			    	$deleted_item = $this->insertLogDeletedItems('0','no','0');
			    	
			    	//gravar log de desfazer correcao
			    	$this->LogInsert($id_specimen,9,$deleted_item);
			    	$this->LogUpdate($id_specimen,$idDQ);
			    	
			    	$criteria = new CDbCriteria;
					$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
					///apos desfazer mostra sugestao
					$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>2,'sugestion'=>1),$criteria);
					
	            	echo CJSON::encode($log_dq_fields);
			    }
			   	else {
			   		echo CJSON::encode(-1);
			   	}
		    	
		    }
		    else if (($idDQ == 5)||($idDQ == 4)){
		    	 $municipality = null;
		    	 $country = null;
		    	 $stateprovince = null;
		    	 
		    	foreach ($log_dq_fields as $logf){
			 	 	if ($logf['field_name']=='municipality') {
			 	 		$municipality = $logf['field_value'] == 0?null:(float) $logf['field_value'];
			 	 	}
		    		else if ($logf['field_name']=='country') {
			 	 		$country = $logf['field_value'] == 0?null:(float) $logf['field_value'];
			 	 	}
			 	 	else if ($logf['field_name']=='stateprovince') {
			 	 		$stateprovince = $logf['field_value'] == 0?null:(float) $logf['field_value'];
			 	 	}
			    }
			    
			    //alterar tabela
			    $locUndoReturn=$this->UpdateLocality($id_specimen,$idLocElement,$country,$municipality,$stateprovince);
			    
		    	
			   
			    if ($locUndoReturn==1){
			    	
			    	//grava 'no' nos items deletados
			    	
			    	$deleted_item = $this->insertLogDeletedItems('0','no','0');
			    	
			    	//gravar log de desfazer correcao
			    	$this->LogInsert($id_specimen,9,$deleted_item);
			    	$this->LogUpdate($id_specimen,$idDQ);
			    	
			    	$criteria = new CDbCriteria;
					$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
					$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>2,'sugestion'=>1),$criteria);
			
			    	echo CJSON::encode($log_dq_fields);
			    	
			    	
	            	
			    }
			   	else {
			   		echo CJSON::encode(-1);
			   	}
		    	
		   }
			else if ($idDQ == 8){
		    	$datum = null;
		    	
		    	 
		    	foreach ($log_dq_fields as $logf){
			 	 	if ($logf['field_name']=='geodeticdatum') {
			 	 		$datum = $logf['field_value'];
			 	 	}
		        }
			    
			    //alterar tabela
			    $locUndoReturn=$this->UpdateDatum($datum,$idGeoSpElement);
			    
		    	
			   
			    if ($locUndoReturn==1){
			    	
			    	//grava 'no' nos items deletados
			    	
			    	$deleted_item = $this->insertLogDeletedItems('0','no','0');
			    	
			    	//gravar log de desfazer correcao
			    	$this->LogInsert($id_specimen,9,$deleted_item);
			    	$this->LogUpdate($id_specimen,$idDQ);
			    	
			    	$criteria = new CDbCriteria;
					$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
					$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>2),$criteria);
			    	
			    	if ($datum==''){
			    		$criteria = new CDbCriteria;
						$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
						$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>2,'sugestion'=>1),$criteria);
			    	}
			    	else if ($datum!=''){
			    		$criteria = new CDbCriteria;
						$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
						$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>2,'sugestion'=>1),$criteria);
			    	}
			    		
			    	
	            	echo CJSON::encode($log_dq_fields);
			    }
			   	else {
			   		echo CJSON::encode(-1);
			   	}
		    	
		   }
		else if ($idDQ == 7){
		    	$coordinateuncertainty = null;
		    	
		    	 
		    	foreach ($log_dq_fields as $logf){
			 	 	if ($logf['field_name']=='coordinateuncertaintyinmeters') {
			 	 		$coordinateuncertainty = $logf['field_value'];
			 	 	}
		        }
			    
			    //alterar tabela
			    $locUndoReturn=$this->updateCoordinateUncertainty($coordinateuncertainty,$idGeoSpElement);
			    
		    	
			   
			    if ($locUndoReturn==1){
			    	
			    	//grava 'no' nos items deletados
			    	
			    	$deleted_item = $this->insertLogDeletedItems('0','no','0');
			    	
			    	//gravar log de desfazer correcao
			    	$this->LogInsert($id_specimen,9,$deleted_item);
			    	$this->LogUpdate($id_specimen,$idDQ);
			    	
			    	 if ($coordinateuncertainty!=0){
				    		$criteria = new CDbCriteria;
							$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
							$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>1),$criteria);
				    	}  
				    	else if ($coordinateuncertainty==0){
				    		
				    		$criteria = new CDbCriteria;
							$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
							$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>2),$criteria);
				    	}    	 
	            	echo CJSON::encode($log_dq_fields);
			    }
			   	else {
			   		echo CJSON::encode(-1);
			   	}
		    	
		   }
		  else if (($idDQ == 6)||($idDQ == 3)){
		  	 	 $idgenus = null;
		    	 $idfamily = null;
		    	 $idorder = null;
		    	 $idclass = null;
		    	 $idphylum = null;
		    	 $idkingdom = null;
		    	 
		    	 $sp=SpecimenAR::model()->with('taxonomicelement')->findbyPK($id_specimen);
			     $idtaxonomicelement = $sp->idtaxonomicelement;
			   
			     $idgenus = $sp->taxonomicelement->idgenus;
			     
		    	 
		    	$returnUpdate = 0;
		    	 
		    	foreach ($log_dq_fields as $logf){
		    		if ($logf['field_name']=='idgenus') {
			 	 		$genus = $logf['field_value'] == 0?null: (int) $logf['field_value'];
						//print_r($new_id);
						//exit;
									
			 	 		$model = 'genus';
			 	 		$old_id = $genus;
			 	 		
			 	 		$class = ucfirst($model).'AR';
			 	 		$object_model = new $class ();
			 	 		$object = $object_model->findbypk($old_id);
			 	 		
   						$logf['field_value'] = $object->$model;
   						
   						$returnUpdate = $this->updateTaxonomicelement($idtaxonomicelement,$model,$old_id,'',$id_specimen,$idDQ,2);  	
   						
			 	 	}else
			 	 	if ($logf['field_name']=='idfamily') {
			 	 		$family = $logf['field_value'] == 0?null: (int) $logf['field_value'];

			 	 		$model = 'family';
   						$old_id = $family;
   						
   						$class = ucfirst($model).'AR';
			 	 		$object_model = new $class ();
			 	 		$object = $object_model->findbypk($old_id);
			 	 		
   						$logf['field_value'] = $object->$model;
   						
   						$returnUpdate = $this->updateTaxonomicelement($idtaxonomicelement,$model,$old_id,'',$id_specimen,$idDQ,2);  	
   						
			 	 	}
		    		else if ($logf['field_name']=='idorder') {
			 	 		$order = $logf['field_value'] == 0?null: (int) $logf['field_value'];

			 	 		$model = 'order';
   						$old_id = $order;
   						
   						$class = ucfirst($model).'AR';
			 	 		$object_model = new $class ();
			 	 		$object = $object_model->findbypk($old_id);
			 	 		
   						$logf['field_value'] = $object->$model;
   						
   						
   						$returnUpdate = $this->updateTaxonomicelement($idtaxonomicelement,$model,$old_id,'',$id_specimen,$idDQ,2); 
   						
			 	 	}
			 	 	else if ($logf['field_name']=='idclass') {
			 	 		$class = $logf['field_value'] == 0?null: (int) $logf['field_value'];
			 	 		
			 	 		$model = 'class';
   						$old_id = $class;
   						
   						$class = ucfirst($model).'AR';
			 	 		$object_model = new $class ();
			 	 		$object = $object_model->findbypk($old_id);
			 	 		
   						$logf['field_value'] = $object->$model;
   						
   						$returnUpdate = $this->updateTaxonomicelement($idtaxonomicelement,$model,$old_id,'',$id_specimen,$idDQ,2); 
   						
			 	 	}
		    		else if ($logf['field_name']=='idphylum') {
			 	 		$phylum = $logf['field_value'] == 0?null: (int) $logf['field_value'];
			 	 		
			 	 		$model = 'phylum';
   						$old_id = $phylum;
   						
   						$class = ucfirst($model).'AR';
			 	 		$object_model = new $class ();
			 	 		$object = $object_model->findbypk($old_id);
			 	 		
   						$logf['field_value'] = $object->$model;
   						
   						$returnUpdate = $this->updateTaxonomicelement($idtaxonomicelement,$model,$old_id,'',$id_specimen,$idDQ,2); 
   						
			 	 	}
			 	 	else if ($logf['field_name']=='idkingdom') {
			 	 		$kingdom = $logf['field_value'] == 0?null: (int) $logf['field_value'];
			 	 		
			 	 		$model = 'kingdom';
   						$old_id = $kingdom;
   						
   						$class = ucfirst($model).'AR';
			 	 		$object_model = new $class ();
			 	 		$object = $object_model->findbypk($old_id);
			 	 		
   						$logf['field_value'] = $object->$model;
   						
   						$returnUpdate = $this->updateTaxonomicelement($idtaxonomicelement,$model,$old_id,'',$id_specimen,$idDQ,2); 
			 	 	}
			    }
			    
			    if($idDQ==3){
			    	$return = TaxonomicElementAR::model()->updateAll(array('colvalidation'=>null),$criteria);
			    }
		 
			    //alterar tabela
			    //$locUndoReturn=$this->UpdateLocality($id_specimen,$idLocElement,$country,$municipality,$stateprovince);
			    
		    	
			   
			    if ($returnUpdate==1){
			    	
			    	//grava 'no' nos items deletados
			    	
			    	$deleted_item = $this->insertLogDeletedItems('0','no','0');
			    	
			    	//gravar log de desfazer correcao
			    	$this->LogInsert($id_specimen,9,$deleted_item);
			    	$this->LogUpdate($id_specimen,$idDQ);
			    	
			    	//$log_dq_fields_return [] = array();
			    	
			    	$sp=SpecimenAR::model()->with('taxonomicelement')->findbyPK($id_specimen);
			     	$idtaxonomicelement = $sp->idtaxonomicelement;
			   		
			     	$tx=TaxonomicElementAR::model()->with('genus')->with('family')->with('order')->with('class')->with('phylum')->with('kingdom')->findbyPK($idtaxonomicelement);
			     	
			     	$ngenus = $tx->genus->genus;
			     	$nfamily = $tx->family->family;
			     	$norder = $tx->order->order;
			     	$nclass = $tx->class->class;
			     	$nphylum = $tx->phylum->phylum;
			     	$nkingdom = $tx->kingdom->kingdom;
			     
			    	$log_dq_fields_return[] = array ('field_name'=>'idgenus', 'field_value'=>$ngenus);
			    	$log_dq_fields_return [] = array ('field_name'=>'idfamily', 'field_value'=>$nfamily);
			    	$log_dq_fields_return [] = array ('field_name'=>'idorder', 'field_value'=>$norder);
			    	$log_dq_fields_return [] = array ('field_name'=>'idclass', 'field_value'=>$nclass);
			    	$log_dq_fields_return [] = array ('field_name'=>'idphylum', 'field_value'=>$nphylum);
			    	$log_dq_fields_return [] = array ('field_name'=>'idkingdom', 'field_value'=>$nkingdom);
			    	
			    	
			    	$criteria = new CDbCriteria;
					$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
					$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>2,'sugestion'=>1),$criteria);
	   					
						
			    	echo CJSON::encode($log_dq_fields_return);
			    	
	            	
			    }
			   	else {
			   		echo CJSON::encode(-1);
			   	}
		    	
		   }
		   $this->UpdateModifyRecordlevelelement($id_specimen);
		   $trans->commit();
		
	}
	
	public function insertLogFields($array_fields){
		
		foreach ($array_fields as $fields){
			$log_dq_fields = new Log_dq_fieldsAR();
            $log_dq_fields->id_log_dq = $fields['id_log_dq'];
            $log_dq_fields->field_name = $fields['field'];
            
            if ((($fields['field']=='longitude')||($fields['field']=='latitude'))&&($fields['value']==0)){
            	$log_dq_fields->field_value=null;
            }else{
            	$log_dq_fields->field_value=$fields['value'];
            }
            
           	$log_dq_fields->save();
		}
		
	}
	
	public function insertLogDeletedItems($type,$old_name,$new_id){
		
			$log_dq_deleted_items = new log_dq_deleted_itemsAR();
            $log_dq_deleted_items->item_type = $type;
            $log_dq_deleted_items->item_name = $old_name;
            $log_dq_deleted_items->id_current_taxon = $new_id;
            
            $log_dq_deleted_items->save();
           	return $log_dq_deleted_items->id;
           	            
		
		
	}
	
	public function actionUpdateTaxonsSugestions(){
		
	
		$id_taxon = (int) $_POST['id_taxon'];
		$value = $_POST['value'];
		$taxonType = (int) $_POST['taxonType'];
		$idDQ = (int) $_POST['idDQ'];
		
		
		$taxon_name_type = $this->getTaxonTypeName($taxonType);
		
		///logs (TO DO)
		
		
					//Abre transacao
						$trans = Yii::app()->db->beginTransaction();
						$model_class = ucfirst($taxon_name_type).'AR';
						$model = new $model_class ();
						$old_name =  $model->findByPK($id_taxon)->$taxon_name_type;
						
										    
						//localiza se já existe
						
						$model_object = $model->findByAttributes(array(($taxon_name_type)=>($value)));
						
						
						//Inserir taxon se nao existir
						$new_taxon = 0;
						if ($model_object == null){
							
							$model->$taxon_name_type = $value;
							$model->colvalidation = 't';
							$model->save();
							$new_taxon = 1;
						}
						
						$success_all = 0;
						$success_update = null;
						$success_log = null;
						$success_delete = null;
						
						$model_object = $model->findByAttributes(array(($taxon_name_type)=>($value)));
						
						if ($model_object != null){
							$id = 'id'.$taxon_name_type;
							$new_id = $model_object[$id];
							
							///procura todos os ids de TaxonomicElement com o id que devera ser trocado
							$taxElements= TaxonomicElementAR::model()->findAllByAttributes(array($id=>$id_taxon));
							
							$taxElementsIds= array();
							if (is_array($taxElements)){
								foreach($taxElements as $te){
									$taxElementsIds[] = $te->idtaxonomicelement;
								}
								
							
							
								//encontra todas as specimens com o mesmo idtaxonomicelement
								$criteria = new CDbCriteria();
								$criteria->addInCondition("idtaxonomicelement", $taxElementsIds);
	   						    $sp = SpecimenAR::model()->findAll($criteria);
	   						    
	   						   		
								    $log_dq_delete_items_id = $this->insertLogDeletedItems($taxon_name_type,$old_name,$new_id);
									
									if ($log_dq_delete_items_id){				 
			   						    //Gravar Logs dessas especies
										if (is_array($sp)){
											foreach($sp as $s){
													//log das especies que terao taxon id alterado
													$log_id_insert = $this->LogInsert($s->idspecimen,$idDQ,$log_dq_delete_items_id);
													 if ($log_id_insert>0){
													 	///log do taxon errado que sera excluido
													 	//$log_dq_delete_items = $this->insertLogDeletedItems($log_id_insert,$taxon_name_type,$old_name);
													 	
													 }
													 //update data do recordlevel
													  $this->UpdateModifyRecordlevelelement($s->idspecimen);
												}
		
										}
									}
	   						    
								$criteria = new CDbCriteria;
								$criteria->addCondition($id.'='.$id_taxon);
								//print_r($new_id);
								
								$success_update = TaxonomicElementAR::model()->updateAll(array($id=>$new_id),$criteria);
								
								
   						    	 if ($success_update>0){
   						    	  		if ($id_taxon!=$new_id){
	   						    	    	$success_delete = $model->deleteByPk($id_taxon);
	   						    	    	if ($success_delete){
	   						    	    		$success_all = 1;
	   						    	    	}
   						    	  		}
   						    	    	
   						    	  		///atualiza recordlevel modified das especies associadas
   						    	  		
   						    	    	//muda type_execution no log
   						    	  		$criteria = new CDbCriteria;
								  		$criteria->addCondition('id_taxon'.'='.$id_taxon.' and id_taxon_type='.$taxonType);
								  		$success_update = ProcessTaxonExecutionAR::model()->updateAll(array('type_execution'=>4),$criteria);
   						    		
   						    	    }
   						    	  else {
	   						    	  	if ($id_taxon!=$new_id){
	   						    	  		$success_delete = $model->deleteByPk($id_taxon);
	   						    	    	if ($success_delete){
	   						    	    		$model = new log_dq_deleted_itemsAR();
	   						    	    		
	   						    	    		$model->deleteByPk($log_dq_delete_items_id);
	   						    	    		
	   						    	    		$success_all = 2; //sem especies
	   						    	    	}	
   						    	    		//muda type_execution no log
   						    	  		$criteria = new CDbCriteria;
								  		$criteria->addCondition('id_taxon'.'='.$id_taxon.' and id_taxon_type='.$taxonType);
								  		$success_update = ProcessTaxonExecutionAR::model()->updateAll(array('type_execution'=>4),$criteria);
   						    	    		
   						    	    	}
   						    	  }
   						    	  
   						    	  	
   						    }
   						    
   						 
							
						
					}
						
							
					$trans->commit();

			
		
		echo CJSON::encode($success_all);
		
	}
	
	public function actionUpdateCoordinatesSugestions(){
			$trans = Yii::app()->db->beginTransaction();
			$id_specimen = (int) $_POST['id_specimen'];
		
			$sp=SpecimenAR::model()->with('localityelement')->findbyPK($id_specimen);
	   		$idGeoSpElement = $sp->idgeospatialelement;
			$latitude = (float) $_POST['latitude'];
			$longitude = (float) $_POST['longitude'];
		
		
		
			$idDQ = 1; ///TO DO: tem que mudar para um vetor
		
		  
    	 //if ($log_exists==0){
    		 $deleted_item = $this->insertLogDeletedItems('0','no','0');
        	 $return_insert_log = $this->LogInsert($id_specimen,$idDQ,$deleted_item);
        	 
        	 ///Fields
			        	 
        	 ///Buscar valores antigos
        	 $geospatialElement=GeospatialElementAR::model()->findbyPK($idGeoSpElement);
        	 $latitude_old = (float) $geospatialElement->decimallatitude;
        	 $longitude_old = (float) $geospatialElement->decimallongitude;
        	 $georeferenceremark_old = $geospatialElement->georeferenceremark;
        	 $coordinateuncertaintyinmeters_old = $geospatialElement->coordinateuncertaintyinmeters;
        	// echo $latitude_old;
        	 
        	 $log_dqAR = Log_dqAR::model()->findByAttributes(
		    	array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ,'undo_log'=>null));
		    
		     $id_log_dq = $log_dqAR->id;
		     	
        	 $array_fields = array();
        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'longitude',"value"=>$longitude_old);
        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'latitude',"value"=>$latitude_old);
        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'georeferenceremark',"value"=>$georeferenceremark_old);
        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'coordinateuncertaintyinmeters',"value"=>$coordinateuncertaintyinmeters_old);
        	  
        	 $returnInsertFields = $this->insertLogFields($array_fields);
        	 
             	         	 
        	 $meters = $this->GetGeolocate($latitude,$longitude);
			  
			        	 
        	 ///alterar tabela

        	 $returnUpdateSugestions = $this->UpdateCoordinates($id_specimen,$idGeoSpElement,$latitude,$longitude,$meters);
        	 $this->UpdateModifyRecordlevelelement($id_specimen);
        	 $trans->commit();
        	 
        	 //muda type_execution no log
   			$criteria = new CDbCriteria;
			$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
			$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>1,'sugestion'=>0),$criteria);
								  		
        	
        	 
        	 
    	 //}
			    	 
		echo CJSON::encode($returnUpdateSugestions);///itens corrigidos
		    
	}
	
	public function GetGeolocate($latitude,$longitude){   
		
		$rs = (file_get_contents(
    	("http://api.geonames.org/findNearbyPlaceNameJSON?lat=".$latitude."&lng=".$longitude."&username=beatrizpd")));
		
		
	    $data = json_decode($rs,true);

		$Geonames = $data['geonames'][0];

		return $Geonames['distance']*1000;
    	
   
    	
    }
    

		
	   	
		
	public function UpdateCoordinates($id_specimen,$idGeoSpElement,$latitude,$longitude,$coordinateuncertaintyinmeters){
		
		
		
    
		$georeferenceremark = "The Google Geocoding API";
		$geoReturn=GeospatialElementAR::model()->updateByPk($idGeoSpElement,array('coordinateuncertaintyinmeters'=>$coordinateuncertaintyinmeters,
														'decimallongitude'=>$longitude,
	   		 														'decimallatitude'=>$latitude,'georeferenceremark'=>$georeferenceremark));
	   		
	    if ($geoReturn==1){
            return 1;
	            
		 }
		   else {
		        return -1;
		    }
		         
		
	}
	
	public function actionSugestionsCoordinates(){
		
		
		$id_specimen = (int) $_POST['id_specimen'];
		
		$sp=SpecimenAR::model()->with('localityelement')->findbyPK($id_specimen);
   		$idGeoSpElement = $sp->idgeospatialelement;
   		
   		///retorno da função searchCoordinates
   		
   		$array_localities = $this->SearchCoordinates($idGeoSpElement);
   		
   		echo CJSON::encode($array_localities);
	}
	
	
	public function Coordinates($id_specimen){
		 
		
		 $trans = Yii::app()->db->beginTransaction();
		  
		//$id_specimen = (int) $_POST['id_specimen'];
		
		$sp=SpecimenAR::model()->with('localityelement')->findbyPK($id_specimen);
   		$idGeoSpElement = $sp->idgeospatialelement;
   		
   		///retorno da função searchCoordinates
   		
   		$array_localities = $this->SearchCoordinates($idGeoSpElement);
   	
   		
   		
   		$latitude = (float) $_POST['latitude']?$_POST['latitude']:$array_localities[0]["latitude"];
		$longitude = (float) $_POST['longitude']?$_POST['longitude']:$array_localities [0]["longitude"];
		
		$returnUpdate = 0;
		
		if ($array_localities == -9){
			return -9;			
		}
		
		if (is_array($array_localities)){
				if (sizeof($array_localities)==1){
					//verificar se ja existe log de alteração
					
					 $idDQ = 1; ///TO DO: tem que mudar para um vetor
					
					 $log_exists = $this->LogSearchUpdate($id_specimen,$idDQ);

					 ///Buscar valores antigos
		        	 $geospatialElement=GeospatialElementAR::model()->findbyPK($idGeoSpElement);
		        	 $latitude_old = (float) $geospatialElement->decimallatitude;
		        	 $longitude_old = (float) $geospatialElement->decimallongitude;
		        	 $georeferenceremark_old = $geospatialElement->georeferenceremark;
			        	 
			    	 if (($latitude_old==0) || ($longitude_old ==0)) {
			    	 	 $deleted_item = $this->insertLogDeletedItems('0','no','0');
			        	 $this->LogInsert($id_specimen,$idDQ,$deleted_item);
			        				           	 
			        	 
			        	 ///Fields
			        	 
			        	 ///Buscar valores antigos
			        	 $geospatialElement=GeospatialElementAR::model()->findbyPK($idGeoSpElement);
			        	 $latitude_old = (float) $geospatialElement->decimallatitude;
			        	 $longitude_old = (float) $geospatialElement->decimallongitude;
			        	 $georeferenceremark_old = $geospatialElement->georeferenceremark;
        	 			 $coordinateuncertaintyinmeters_old = $geospatialElement->coordinateuncertaintyinmeters;
			        				        	 
			        	 $log_dqAR = Log_dqAR::model()->findByAttributes(
					    	array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ,'undo_log'=>null));
					    
					     $id_log_dq = $log_dqAR->id;
					     	
			        	 $array_fields = array();
			        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'longitude',"value"=>$longitude_old);
			        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'latitude',"value"=>$latitude_old);
			        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'georeferenceremark',"value"=>$georeferenceremark_old);
			        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'coordinateuncertaintyinmeters',"value"=>$coordinateuncertaintyinmeters_old);
			        	 $returnInsertFields = $this->insertLogFields($array_fields);
			        	         	 
			      			   		 
			        	         	 
			        	$meters = $this->GetGeolocate($latitude,$longitude);
			        	 
			        	 
			        	 $returnUpdate = $this->UpdateCoordinates($id_specimen,$idGeoSpElement,$latitude,$longitude,$meters);
			        	 $returnUpdate = 1;
			        	 $this->UpdateModifyRecordlevelelement($id_specimen);
        	 
			    	 }

			    	 $trans->commit();	 
					 return 1; //correcao
					  
					
				}
				else if (sizeof($array_localities)>1){
					$trans->commit();	 
					return $array_localities; //deteccao
				}
				else {
					$trans->commit();	 
					return 2; ///deteccao
				}
				
				
				
		}
		else {
			$trans->commit();	 
			 return 2;//nao encontrou coordenadas
		}     
		
	}
	 public function SearchCoordinates($idGeoSpElement){
	 	
   		 $locality=LocalityElementAR::model()->with('country', 'municipality', 'stateprovince')->together()->findbyPK($idGeoSpElement);
   		    		 
   		 $country = $locality->country['country'];
   		 $municipality = $locality->municipality['municipality'];
   		 $stateprovince = $locality->stateprovince['stateprovince'];
   		 
   		 $address = $municipality.'+'.$stateprovince.'+'.$country;
	
		 $URL = 'http://maps.googleapis.com/maps/api/geocode/json?';   
       	 $options = array("address"=>$address,"sensor"=>"false");
   		 $URL .= http_build_query($options,'','&');

   		 $jason_dta = file_get_contents($URL) or die(print_r(error_get_last()));
    	
   		 $output= json_decode($jason_dta,true);
		 if ($output['status']=='OK'){
			 $array_locaties = array();
	   		 foreach ($output['results'] as $res){
	   		 	 
	   		 	  $locality = '';
	   		 	  $state = '';
	   		 	  $country = '';
	   		 	  
	   		 	  $sub = 0;
	   		 	  
		   		  foreach ($res['address_components'] as $adc){
		   		 	
		   		  	 
		   		 	 if ($adc["types"][0] == "sublocality"){
		   		  		$sub = 1;
		   		  	 }
		   		  	
		   		  	if ($adc["types"][0] == "administrative_area_level_1"){
		   		  	
		   		  		$state = $adc["long_name"];
		   		  	}
		   		  	
		   		 	 if ($adc["types"][0] == "locality"){
		   		  		$locality = $adc["long_name"];
		   	
		   		  	}
		   		   if ($adc["types"][0] == "country"){
		   		  		$country = $adc["long_name"];
		   	
		   		  	}
		   		 	
		   		 	
		   		 }
		   		 $latitude = $res['geometry']['location']['lat'];
		   		 $longitude =$res['geometry']['location']['lng'];
		   		 $formatted_address= $locality.', '.$state.', '.$country;
		   		 
		   		 if (($sub == 0)){
		   		 	if($locality!=''){
			   			$array_locaties [] = array("locality"=>$locality,"state"=>$state, "country"=>$country,"latitude"=>$latitude,"longitude"=>$longitude,
			   									"formatted_address"=>$formatted_address);
		   		 	}
		   		 }
		   		
	   		  } //end for
	   		
	   		  return $array_locaties;
		 }
		 else if ($output['status']=='OVER_QUERY_LIMIT'){ 
		 	
		 	return -9;
		 }
   	}
   
    public function actionListSpecimensDQ()
   {
   		$idDQ = (int) $_POST['idDQ'];
        $l = new DataqualityLogic();
        $rs = array();

        $spList = $l->listSpecimenToCorrection($idDQ); 
        $list = array();
        
        if (is_array($spList)){
	        foreach($spList['list'] as $n=>$ar) {
	            $list[] = array(
	                    		"id" => $ar['idspecimen'],
	            				"idGeoSpElement" => $ar['idgeospatialelement'],
	            				"country" => $ar['country'],
			            		"stateprovince" => $ar['stateprovince'],
			            		"municipality" => $ar['municipality'],
	            				"idcountry" => $ar['idcountry'],
					            "idstateprovince" => $ar['idstateprovince'],
					            "idmunicipality" => $ar['idmunicipality'],
		            			"geodeticdatum" => $ar['geodeticdatum'],
	            				"coordinateuncertaintyinmeters" => $ar['coordinateuncertaintyinmeters']
	                                
	            		
	            );
	        }
        }
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
        
   }
    

    public function actionFilter() {
    	$idDQ = (int) $_POST['idDQ'];
        $l = new DataqualityLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filterProcess($idDQ,$filter); 
        $list = array();
        //print_r($spList);
        $idsarray = array();
        $excluir = 0;
        if (is_array($spList)){
	        foreach($spList['list'] as $n=>$ar) {
	        		
	       			 if (!(in_array($ar['idspecimen'], $idsarray,true)))
					  {
					 	$idsarray [] = $ar['idspecimen'];
	        		
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
				            	"scientificname" => $ar['scientificname'],
			            		"latitude" => $ar['latitude'],
			            		"longitude" => $ar['longitude'],
			            		"country" => $ar['country'],
					            "stateprovince" => $ar['stateprovince'],
					            "municipality" => $ar['municipality'],
			            		"idcountry" => $ar['idcountry'],
					            "idstateprovince" => $ar['idstateprovince'],
					            "idmunicipality" => $ar['idmunicipality'],
				            	"geodeticdatum" => $ar['geodeticdatum'],
			            		"coordinateuncertaintyinmeters" => $ar['coordinateuncertaintyinmeters'],
			            		"sugestion" => $ar['sugestion'],
			           			"type_execution" => $ar['type_execution'],
			            		"undo_log" => $ar['undo_log'],		             
			             		"id_log_dq_deleted_items" => $ar['id_log_dq_deleted_items'],
			               
			            		          
			            		
			            );
					  }
					  else {
					  	$excluir ++;
					  }
		        
	        }
        }
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count']-$excluir;
        echo CJSON::encode($rs);
    }
    
 	public function actionFilterOutliers() {
    	$idDQ = (int) $_POST['idDQ'];
        $l = new DataqualityLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list'], 'arrayOut'=>$_POST['arrayOut']);
        $rs = array();
        $rs = array();

        $spList = $l->filterProcess($idDQ,$filter); 
        $list = array();
        //print_r($spList);
        $retOutliers = 0;
        if (is_array($spList)){
	        foreach($spList['list'] as $n=>$ar) {
	        		//$retOutliers = $this->CoordinateOutliers($ar['idspecimen']);
		       
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
			            	"scientificname" => $ar['scientificname'],
		            		"latitude" => $ar['latitude'],
		            		"longitude" => $ar['longitude'],
		            		"country" => $ar['country'],
				            "stateprovince" => $ar['stateprovince'],
				            "municipality" => $ar['municipality'],
		            		"idcountry" => $ar['idcountry'],
				            "idstateprovince" => $ar['idstateprovince'],
				            "idmunicipality" => $ar['idmunicipality'],
			            	"geodeticdatum" => $ar['geodeticdatum'],
		            		"coordinateuncertaintyinmeters" => $ar['coordinateuncertaintyinmeters'],
		            		"outliers" => $retOutliers   
		               
		            		          
		            		
		            );
		        
	        }
        }   
	        
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    
    public function getTaxonTypeName($taxonType){
   		if ($taxonType == 1){
		        $taxonTypeName = 'kingdom';
			}
			else if ($taxonType == 2){
				$taxonTypeName = 'phylum';
			}
			else if ($taxonType == 3){
				$taxonTypeName = 'class';
			}
			else if ($taxonType == 4){
				$taxonTypeName = 'order';
			}
			else if ($taxonType == 5){
							$taxonTypeName = 'family';
			}
			else if ($taxonType == 6){
							$taxonTypeName = 'genus';
			}
    		else if ($taxonType == 7){
							$taxonTypeName = 'scientificName';
			}
    	return $taxonTypeName;
    	
    }
    public function ColEqual($name,$taxon){
		
		$logic = new DataqualityLogic();
        $rs = array();        
		$rs = $logic->searchColEqual($name,$taxon);
        
        return $rs[0]['count'];
    }
    
	public function SearchUndoTaxons($id,$name){
		
		//$id=1;
		//$name="kingdom";
		
		$model = new log_dq_deleted_itemsAR();
        
		$log_dq_deleted_items = $model->findAllByAttributes(array('item_type'=>$name, 'id_current_taxon'=>$id ));
		$item_id= $log_dq_deleted_items[0]->id;
		
		if ($item_id>0){
			$model = new log_dqAR();
        	$log_dq = $model->findAllByAttributes(array('id_log_dq_deleted_items'=>$item_id, 'undo_log'=>null, 'id_type_log'=>'2' ));
        	return $log_dq[0]->id;
		}	
		else {
			return 0;
		}
        
    }
    
	public function actionGetTaxonIdByName(){
		
		//$id=1;
		//$name="kingdom";
	     $taxonTypeName = $_POST['taxonTypeName'];
		$value = $_POST['value'];
		
		
		$model_class = ucfirst($taxonTypeName).'AR';
		$model = new $model_class();
        
		$model_object = $model->findAllByAttributes(array($taxonTypeName=>$value));
		
		$id='id'.$taxonTypeName;
		$ret= $model_object[0]->$id;
		echo CJSON::encode($ret);
        
    }
    
	public function actionFilterTaxon() {
    	$taxonType = (int) $_POST['taxonType'];
        $l = new DataqualityLogic();
        $rs = array();
		
        
        $taxonTypeName = $this->getTaxonTypeName($taxonType);
        
        $spList = $l->filterTaxonsProcess($taxonType); 
        $list = array();
        //print_r($spList);
        $res_undo = 0;
        
        if (is_array($spList)){
	        foreach($spList['list'] as $n=>$ar) {
	        	

		            $list[] = array("id" => $ar['id'],
		                    "value" => $ar['name'],
		            		"id_taxon_type" => $ar['id_taxon_type'],
		            		"sugestion"=>$ar['sugestion']);

		  
	        }
        }
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }	
	
    
 	public function filterTaxonf($taxonType) {
    	//$taxonType = (int) $_POST['taxonType'];
        $l = new DataqualityLogic();
        $rs = array();
        
        $spList = $l->filterTaxons($taxonType); 
        $list = array();
        //print_r($spList);
        $res_undo = 0;
        
        if (is_array($spList)){
	        foreach($spList['list'] as $n=>$ar) {
		            $list[] = array("id" => $ar['id'],
		                    "value" => $ar['name']);

		  
	        }
        }
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        return $rs;
    }
    
   
     public function actionListSpecimenToCorrection() {
    	$idDQ = (int) $_POST['idDQ'];
        $l = new DataqualityLogic();
        
        $rs = array();

        $spList = $l->listSpecimenToCorrection($idDQ); 
        $list = array();
        //print_r($spList);
        if (is_array($spList)){
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
		            	"scientificname" => $ar['scientificname'],
	            		"latitude" => $ar['latitude'],
	            		"longitude" => $ar['longitude'],
	            		"country" => $ar['country'],
			            "stateprovince" => $ar['stateprovince'],
			            "municipality" => $ar['municipality'] , 
	            		"idtaxonomicelement" => $ar['idtaxonomicelement'],
	            		"coordinateuncertaintyinmeters" => $ar['coordinateuncertaintyinmeters']         
	            		
	            );
	        }
        }
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    
	public function actionColSuggestions(){
		
		$value = $_POST['value'];
		$name = $_POST['name'];
		
		if (($name=='scientificname')||($name=='scientificName')){
			$name = 'species';
			
		}
		
        $logic = new DataqualityLogic();
        $rs = array();        
		$rs = $logic->searchColSugestion($value,$name);
        
        echo CJSON::encode($rs);
    }
    
	
    
   public function actionListSpecimensByIdTaxon(){
   		$id_taxon = (int) $_POST['id_taxon'];
		$taxonType = (int) $_POST['taxonType'];
	
        $l = new DataqualityLogic();
        
        $filter = array('limit'=>$_POST['limit']?$_POST['limit']:10,'offset'=>$_POST['offset']?$_POST['offset']:0,'list'=>$_POST['list']);
        $rs = array();
        
      
        $spList = $l->listSpecimenToCorrectionTaxon($filter,$id_taxon,$taxonType);
        $list = array();
 
        if (is_array($spList)){
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
		            	"scientificname" => $ar['scientificname'],
	            		"latitude" => $ar['latitude'],
	            		"longitude" => $ar['longitude'],
	            		"country" => $ar['country'],
			            "stateprovince" => $ar['stateprovince'],
			            "municipality" => $ar['municipality'],
						"idtaxonomicelement" => $ar['idtaxonomicelement'],
	            
	            		
	            );
	        }
        }
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
		
		
   	
   }
   
   
	public function actionGoToListSpecimens() {
        $this->renderPartial('list_specimens',
                array_merge(array(
                'taxonType'=>(int) $_GET['taxonType'],
                'id_taxon'=>(int) $_GET['id_taxon']
                )));
    }
    
    public function actionGetSpecimensFromTaxonomicElem(){
    	
    		$idtaxonomicelement =(int) $_POST['idtaxonomicelement'];
    		$tax=TaxonomicElementAR::model()->findbyPK($idtaxonomicelement);
    		echo CJSON::encode($tax);
    		
 
    }
    
     public function actionUndoCorrectionsTaxons(){
   		$id_taxon = (int) $_POST['id_taxon'];
		$taxonType = (int) $_POST['taxonType'];
		
		    $trans = Yii::app()->db->beginTransaction();
			$taxonTypeName = $this->getTaxonTypeName($taxonType);
			
			//buscar item excluido
			$model = new log_dq_deleted_itemsAR();
			$deleted_item = $model->findByAttributes(array(strtolower('item_type')=>strtolower($taxonTypeName),'id_current_taxon'=>$id_taxon));
			
			//buscar especies que estavam ligadas no item excluido
			$specimens = array();
			$model = new Log_dqAR();
			$specimens = $model->findAllByAttributes(array('id_log_dq_deleted_items'=>$deleted_item->id));
			
			
			$specimensId = array();
			
			foreach ($specimens as $sp){
				//inserir log tipo 9 para todoas as especies
				$this->LogInsert($sp->id_specimen, '9',$deleted_item->id);
				//marcar undo_log =1 para elas no log_dq
				$criteria = new CDbCriteria;
				$criteria->addCondition('id_specimen='.$sp->id_specimen.' and id_type_log=2');
				
				$specimensId [] = $sp->id_specimen;
				
				$update_log_dq = Log_dqAR::model()->updateAll(array('undo_log'=>'1'),$criteria);
			}
			
				//acha taxElements
			
				$list_sp = array();
				
				$criteria = new CDbCriteria();
				$criteria->addInCondition("idspecimen", $specimensId);
    		 	$list_sp= SpecimenAR::model()->findAll($criteria);
							
				 $taxElementsIds= array();
				 if (is_array($list_sp)){
					 foreach($list_sp as $sp){
						 $taxElementsIds[] = $sp->idtaxonomicelement;
				    }
				 }				
								
				///criar novo taxon
				$model_class = ucfirst($taxonTypeName).'AR';
				$model = new $model_class();
				
				$model->$taxonTypeName = $deleted_item->item_name;
				$model->colvalidation = 'f';
				$model->save();
				
				$id = 'id'.strtolower($deleted_item->item_type);
				$model_object = $model->findByAttributes(array(($taxonTypeName)=>($deleted_item->item_name)));
						
				if ($model_object != null){
							$id = 'id'.$taxonTypeName;
							$new_id = $model_object[$id];
				}
				
				
				 if (is_array($taxElementsIds)){
					///update taxonElement
					$criteria = new CDbCriteria;
					$criteria->addInCondition("idtaxonomicelement", $taxElementsIds);
					//$criteria->addCondition($id.'='.$id_taxon);
				    $success_update = TaxonomicElementAR::model()->updateAll(array($id=>$new_id),$criteria);
				    
				 }
		
			  $return = array();
			  $return_array [] = array ('old_name'=>$deleted_item->item_name,'id'=>$new_id); 
			  
			  //muda type_execution no log
   			  $criteria = new CDbCriteria;
			  $criteria->addCondition('name_taxon'."='".$deleted_item->item_name."'".' and id_taxon_type='.$taxonType);
			  $success_update = ProcessTaxonExecutionAR::model()->updateAll(array('type_execution'=>2,'id_taxon'=>$new_id),$criteria);
			  
			  
			  
		      $trans->commit();
		      
		echo CJSON::encode($return_array);
     }
    
   
	public function Locality($id_specimen){
		
		
		$trans = Yii::app()->db->beginTransaction();
		  
		//$id_specimen = (int) $_POST['id_specimen'];
		$idDQ = 5;
		
		$sp=SpecimenAR::model()->with('localityelement')->findbyPK($id_specimen);
   		$idLocElement = $sp->idlocalityelement;
   		
   		///retorno da função searchCoordinates
   		
   		$array_localities = $this->SearchLocality($id_specimen);
   		  
   		if ($array_localities == -9){
		  return -9;			
		}
   		
   		//print_r($array_localities);
   		
   		//$array_localities [] = array ('idmunicipality'=>1,'idcountry'=>1, 'idstateprovince'=>1);
   		
   		$idcountry = (int) $_POST['idcountry']?$_POST['idcountry']:$array_localities[0]["idcountry"];
		$idmunicipality = (int) $_POST['idmunicipality']?$_POST['idmunicipality']:$array_localities [0]["idmunicipality"];
		$idstateprovince = (int) $_POST['idstateprovince']?$_POST['idstateprovince']:$array_localities [0]["idstateprovince"];
		
		$returnUpdate = 0;
		
		//echo  CJSON::encode($array_localities);
		
		if (is_array($array_localities)){
				if (sizeof($array_localities)==1){
					
					//verificar se ja existe log de alteração
					
					 $idDQ = 5; 
					
					 $log_exists = $this->LogSearchUpdate($id_specimen,$idDQ);

					 ///Buscar valores antigos
		        	 $LocElement=LocalityElementAR::model()->findbyPK($idLocElement);
		        	 $idcountry_old = (int) $LocElement->idcountry;
		        	 $idmunicipality_old = (int) $LocElement->idmunicipality;
		        	 $idstateprovince_old = (int) $LocElement->idstateprovince;
			         	 
			    	 if (($idmunicipality_old==0)&&($idDQ==5)) {
			    	 	
			        	         	 
			        	 $returnUpdate = $this->UpdateLocality($id_specimen,$idLocElement,$idcountry,$idmunicipality,$idstateprovince);
			        	 $this->UpdateModifyRecordlevelelement($id_specimen);
			        	 
			        	 
			        	 if ($returnUpdate>0){
			        	 	
			        	 	 $deleted_item = $this->insertLogDeletedItems('0','no','0');
				        	 $this->LogInsert($id_specimen,$idDQ,$deleted_item);
				        				           	 
				        	 
				        	   				        	 
				        	 $log_dqAR = Log_dqAR::model()->findByAttributes(
						    	array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ,'undo_log'=>null));
						    
						     $id_log_dq = $log_dqAR->id;
						     	
				        	 $array_fields = array();
				        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'idcountry',"value"=>$idcountry_old);
				        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'idmunicipality',"value"=>$idmunicipality_old);
				        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'idstateprovince',"value"=>$idstateprovince_old);
				        	
				        	 
				        	 $returnInsertFields = $this->insertLogFields($array_fields);
				        	 
				        	 $returnUpdate = 1;
				        	 $trans->commit();
				        	 return 1;///correct
				        	 	
			        	 	
			        	 }
			        	 
			        	 
        	 
			    	 }
			    	 
	    	 			
					 
					
				}
				else if (sizeof($array_localities)>0){
					$returnUpdate = 1;
					$trans->commit();	
					return 2;///detect
				}
				else {
					
					$trans->commit();	
					return 2;///detect
				}
				
				//echo CJSON::encode($returnUpdate);///itens corrigidos
				
		}
		else {
			 //echo CJSON::encode(2);//nao encontrou coordenadas
			
			 $trans->commit();	
			  return 2;///detect
		}     
		
		$trans->commit();	
		 
	}   
	
	public function UpdateLocality($id_specimen,$idLocElement,$idcountry,$idmunicipality,$idstateprovince){
		
		//print_r('- '.$idmunicipality.'-');
		$locReturn=LocalityElementAR::model()->updateByPk($idLocElement,
						array ('idmunicipality'=>$idmunicipality,'idcountry'=>$idcountry, 'idstateprovince'=>$idstateprovince));
	   	
	   		
	    if ($locReturn==1){
            return 1;
	            
		 }
		   else {
		        return -1;
		    }
		         
		
	}
	
	public function SearchLocality($id_specimen){
	 	
		 //$id_specimen = 83;	 
		 $sp=SpecimenAR::model()->with('localityelement')->findbyPK($id_specimen);
   		 $idGeoSpElement = $sp->idgeospatialelement;
   		
   		 $geospatialElement=GeospatialElementAR::model()->findbyPK($idGeoSpElement);
         $latitude = (float) $geospatialElement->decimallatitude;
         $longitude = (float) $geospatialElement->decimallongitude;
         
   		 
   		$latlng = $latitude.','.$longitude;
	
		 $URL = 'http://maps.googleapis.com/maps/api/geocode/json?';   
       	 $options = array("latlng"=>$latlng,"sensor"=>"false");
   		 $URL .= http_build_query($options,'','&');

   		 $jason_dta = file_get_contents($URL) or die(print_r(error_get_last()));
    	
   		 $output= json_decode($jason_dta,true);
		
   		 if ($output['status']=='OK'){
   		 
		 $array_localities = array();
		 
   		 foreach ($output['results'] as $res){
   		 	 
   		 	  $municipality = '';
   		 	  $stateprovince = '';
   		 	  $country = '';
   		 	  
   		 	  $sub = 0;
   		 	  $i = 1;
	   		  foreach ($res['address_components'] as $adc){
	   		 	
	   		  	 
	   		 	 if ($adc["types"][0] == "sublocality"){
	   		  		$sub = 1;
	   		  	 }
	   		  	
	   		  	if ($adc["types"][0] == "administrative_area_level_1"){
	   		  	
	   		  		$stateprovince  = $adc["long_name"];
	   		  	}
	   		  	
	   		 	 if ($adc["types"][0] == "locality"){
	   		  		$municipality = $adc["long_name"];
	   		  		
	   	
	   		  	}
	   		   if ($adc["types"][0] == "country"){
	   		  		$country = $adc["long_name"];
	   	
	   		  	}
	   		 	
	   		 	
	   		 }
	   		 
	   		 if ($municipality!=''){
		   		 $formatted_address= $municipality.', '.$stateprovince.', '.$country;
		   		 
		   		 
		   		 //buscar ids country, locality e stateprovince
		   		 $criteria_country = new CDbCriteria;
				 $criteria_country->addCondition("lower(country)='".strtolower($country)."'");
		   		 $country_object = CountryAR::model()->findAll($criteria_country);
		   		 $idcountry = $country_object[0]->idcountry;
		   		 
		   		 
		   		 $criteria_municipality  = new CDbCriteria;
				 $criteria_municipality->addCondition("lower(municipality)='".strtolower($municipality)."'");
		   		 $municipality_object = MunicipalityAR::model()->findAll($criteria_municipality);
		   		 $idmunicipality_bd = (int) $municipality_object[0]->idmunicipality;
	   		 
		   		 
		   		 $criteria_stateprovince  = new CDbCriteria;
				 $criteria_stateprovince->addCondition("lower(stateprovince)='".strtolower($stateprovince)."'");
		   		 $stateprovince_object = StateProvinceAR::model()->findAll($criteria_stateprovince);
		   		 $idstateprovince_bd = $stateprovince_object[0]->idstateprovince;
	   		 
	   		 }
	   		 
	   		 if (($idmunicipality_bd == 0)&&($municipality!='')){
	   		 	$municipality_model = new MunicipalityAR();
	   		 	$municipality_model->municipality = $municipality;
	   		 	$municipality_model->googlevalidation = 't';
	   		 	$municipality_save = $municipality_model->Save();
	   		 	$idmunicipality = $municipality_save->idmunicipality;
	   		 	//print $idmunicipality;
	   		 	
	   		 }
	   		 else{
	   		 	$idmunicipality = $idmunicipality_bd;
	   		 }
	   		 
   		 	 if (($idstateprovince_bd == 0)&&($stateprovince!='')){
	   		 	$stateprovince_model = new StateProvinceAR();
	   		 	$stateprovince_model->stateprovince = $stateprovince;
	   		 	$stateprovince_model->googlevalidation = 't';
	   		 	$stateprovince_save = $stateprovince_model->Save();
	   		 	$idstateprovince = $stateprovince_save->stateprovince;
	   		 	//print $idmunicipality;
	   		 	
	   		 }
	   		 else{
	   		 	$idstateprovince = $idstateprovince_bd;
	   		 }
	   		 
	   		
	   		 
	   		
		     //$idstateprovince 
		
	   		 if (($sub == 0)){
	   		 	if(($municipality!='')&&($idmunicipality>0)){
		   			$array_localities [0] = array("idmunicipality"=>$idmunicipality,"idstateprovince"=>$idstateprovince, "idcountry"=>$idcountry,"latitude"=>$latitude,"longitude"=>$longitude,
		   									"formatted_address"=>$formatted_address,"country"=>$country,"municipality"=>$municipality,"state"=>$stateprovince);
	   		 	}
	   		 }
	   		
   		  } //end for
   		
   		  //print_r($res['address_components']);
   		  return $array_localities;
   		 }
   		 else if ($output['status']=='OVER_QUERY_LIMIT'){ 
		 	
		 	return -9;
		 }
		 
   	}
   	
   	public function actionUpdateDatumSugestion(){
   		
   		$idDQ = (int) $_POST['idDQ'];
		$id_specimen = (int) $_POST['id_specimen'];
		
		$sp=SpecimenAR::model()->with('geospatialelement')->findbyPK($id_specimen);
   		$idGeoSpElement = $sp->idgeospatialelement;
   		
   		$geo= GeospatialElementAR::model()->findbyPK($idGeoSpElement);
   		
   	   		
   		$datum_padrão = 'WGS84';
   		
   		$geoReturn= $this->updateDatum($datum_padrão,$idGeoSpElement);
   		
   		echo CJSON::encode($geoReturn);
   		
   	}
   	public function updateDatum($datum,$idGeoSpElement){
   
   		$geoReturn=GeospatialElementAR::model()->updateByPk($idGeoSpElement,array('geodeticdatum'=>$datum));
	   	
	   		
	    if ($geoReturn==1){
            return 1;
	            
		 }
		   else {
		        return -1;
		    }
   		
   	}
   	
	public function updateCoordinateUncertainty($meters,$idGeoSpElement){
   
   		$geoReturn=GeospatialElementAR::model()->updateByPk($idGeoSpElement,array('coordinateuncertaintyinmeters'=>$meters));
	   	
	   		
	    if ($geoReturn==1){
	    	
	    	
            return 1;
	            
		 }
		   else {
		        return -1;
		    }
   		
   	}
   	public function Datum($id_specimen){
		
		$trans = Yii::app()->db->beginTransaction();
		  
		//$id_specimen = (int) $_POST['id_specimen'];
		$idDQ = 8;
		
		$sp=SpecimenAR::model()->with('geospatialelement')->findbyPK($id_specimen);
   		$idGeoSpElement = $sp->idgeospatialelement;
   		
   		$geo= GeospatialElementAR::model()->findbyPK($idGeoSpElement);
   		
   		$datum_atual = $geo->geodeticdatum;
   		
   		$datum_padrão = 'WGS84';
   		
   		if (strlen($datum_atual)==0){
	   		$retun_update = $this->updateDatum($datum_padrão,$idGeoSpElement);
	   		$this->UpdateModifyRecordlevelelement($id_specimen);
	   		//$trans->commit();	
	   		
	   		if ($retun_update>0){
	   			
	   			 $deleted_item = $this->insertLogDeletedItems('0','no','0');
	        	 $this->LogInsert($id_specimen,$idDQ,$deleted_item);
	             	   				        	 
	        	 $log_dqAR = Log_dqAR::model()->findByAttributes(
			    	array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ,'undo_log'=>null));
			    
			     $id_log_dq = $log_dqAR->id;
			     	
	        	 $array_fields = array();
	        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'geodeticdatum',"value"=>$datum_atual);	        	
	        	 
	        	 $returnInsertFields = $this->insertLogFields($array_fields);
	        	 
	        	 $returnUpdate = 1;
	        	 $trans->commit();	
	        	 return 1;//correção
				        	 
				        	 
	   			echo CJSON::encode($returnUpdate);
	   		}
	   		else {
	   			$trans->commit();	
	   			return 3;//nao faz nada
	   		}
   		} else{
   			$trans->commit();	
   			return 3;//nao faz nada
   		}  		
   		
		 
	}  
	
	public function undoSP($id_specimen,$idDQ){

		$deleted_item = $this->insertLogDeletedItems('0','no','0');
		    	
		//gravar log de desfazer correcao
		$this->LogInsert($id_specimen,9,$deleted_item);
		$this->LogUpdate($id_specimen,$idDQ);
		    	
        return 1;
		  
	}
	public function actionDatumSP(){
		$id_specimen = (int) $_POST['id_specimen'];
		$datum =  $_POST['datum'];
		$idDQ = (int) $_POST['idDQ'];
		
		$sp=SpecimenAR::model()->with('geospatialelement')->findbyPK($id_specimen);
   		$idGeoSpElement = $sp->idgeospatialelement;
   		
   		$geoReturn=GeospatialElementAR::model()->findAllByPk($idGeoSpElement);
   		$datum_atual = $geoReturn[0]->geodeticdatum;
   		
   		
   		
   		if ($geoReturn){
			$retun_update = $this->updateDatum($datum,$idGeoSpElement);
			$this->UpdateModifyRecordlevelelement($id_specimen);
			if ($retun_update>0){
		   			
				
					///marcar como undo
					
				     $undo = $this->undoSP($id_specimen,$idDQ);
				     
				     if ($undo ==1){
			   			 $deleted_item = $this->insertLogDeletedItems('0','no','0');
			        	 $this->LogInsert($id_specimen,$idDQ,$deleted_item);
			             	   				        	 
			        	 $log_dqAR = Log_dqAR::model()->findByAttributes(
					    	array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ,'undo_log'=>null));
					    
					     $id_log_dq = $log_dqAR->id;
					     	
			        	 $array_fields = array();
			        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'geodeticdatum',"value"=>$datum_atual);	        	
			        	 
			        	 $returnInsertFields = $this->insertLogFields($array_fields);
			        	 
			        	 $returnUpdate = 1;
					     if ($datum!=''){
				    		$criteria = new CDbCriteria;
							$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
							$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>1,'sugestion'=>0),$criteria);
				    	}  
				    	else if ($datum==''){
				    		
				    		$criteria = new CDbCriteria;
							$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
							$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>2,'sugestion'=>1),$criteria);
				    	}    	 
						        	 
			   			echo CJSON::encode($returnUpdate);
				     }
				     else {
				     	echo CJSON::encode(0);
				     }
		   		}
		   		else {
		   			echo CJSON::encode(0);
		   		}
   		}else{
   			echo CJSON::encode(0);
   		}
	}
	
	public function actionCoordinateUncertaintySP(){
		$id_specimen = (int) $_POST['id_specimen'];
		$meters =  $_POST['meters'];
		$idDQ = (int) $_POST['idDQ'];
		
		$sp=SpecimenAR::model()->with('geospatialelement')->findbyPK($id_specimen);
   		$idGeoSpElement = $sp->idgeospatialelement;
   		
   		$geoReturn=GeospatialElementAR::model()->findAllByPk($idGeoSpElement);
   		$meters_atual = $geoReturn[0]->coordinateuncertaintyinmeters;
   		
   		
   		
   		if ($geoReturn){
			$retun_update = $this->updateCoordinateUncertainty($meters,$idGeoSpElement);
			$this->UpdateModifyRecordlevelelement($id_specimen);
			if ($retun_update>0){
		   			
				
					///marcar como undo
					
				     $undo = $this->undoSP($id_specimen,$idDQ);
				     
				     if ($undo ==1){
			   			 $deleted_item = $this->insertLogDeletedItems('0','no','0');
			        	 $this->LogInsert($id_specimen,$idDQ,$deleted_item);
			             	   				        	 
			        	 $log_dqAR = Log_dqAR::model()->findByAttributes(
					    	array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ,'undo_log'=>null));
					    
					     $id_log_dq = $log_dqAR->id;
					     	
			        	 $array_fields = array();
			        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'coordinateuncertaintyinmeters',"value"=>$meters_atual);	        	
			        	 
			        	 $returnInsertFields = $this->insertLogFields($array_fields);
			        	 
			        	 $returnUpdate = 1;
			        	 $criteria = new CDbCriteria;
						 $criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
						 $success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>1),$criteria);
							
						 /*
			        	 if ($meters!=0){
				    		$criteria = new CDbCriteria;
							$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
							$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>1),$criteria);
				    	}  
				    	else if ($meters==0){
				    		
				    		$criteria = new CDbCriteria;
							$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
							$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>2),$criteria);
				    	} */   	 
				    	
			   			echo CJSON::encode($returnUpdate);
				     }
				     else {
				     	echo CJSON::encode(0);
				     }
		   		}
		   		else {
		   			echo CJSON::encode(0);
		   		}
   		}else{
   			echo CJSON::encode(0);
   		}
	}
	public function actionEditUncertainty() {
        $this->renderPartial('uncertainty_coordinate',
                array_merge(array(
                'uncertainty'=>(float) $_GET['uncertainty'],
                'lng'=>(float) $_GET['lng'],
                'lat'=>(float) $_GET['lat'],
                )));
    }
    
public function actionGetLatitudeLongitude() {
	
       $id_specimen = (int) $_POST['id_specimen'];
       $sp=SpecimenAR::model()->with('geospatialelement')->findbyPK($id_specimen);
   	   $idGeoSpElement = $sp->idgeospatialelement;
   	   $geoReturn=GeospatialElementAR::model()->findAllByPk($idGeoSpElement);
   	   
   	   $latitude = $geoReturn[0]->decimallatitude;
   	   $longitude = $geoReturn[0]->decimallongitude;
   	   
   	   $array_fields [] = array("latitude"=>$latitude,"longitude"=>$longitude);	
   	   echo CJSON::encode($array_fields);
   	   
   		
}
public function actionSugestionsLocality(){
	 $id_specimen = (int) $_POST['id_specimen'];
	 $array_localities = $this->SearchLocality($id_specimen);
	 	   
	 echo CJSON::encode($array_localities);
}

public function actionUpdateLocality(){
	$id_specimen = (int) $_POST['id_specimen'];
	$idcountry = (int) $_POST['country'];
	$idmunicipality = (int) $_POST['locality'];
	$idstateprovince = (int) $_POST['state'];
	$idDQ = (int) $_POST['idDQ'];
	
	$sp=SpecimenAR::model()->with('geospatialelement')->findbyPK($id_specimen);
   	$idGeoSpElement = $sp->idgeospatialelement;
   	$geoReturn=GeospatialElementAR::model()->findAllByPk($idGeoSpElement);
   	   
   	$idlocSpElement = $sp->idlocalityelement;
   	   
	$returnUpdate = $this->updateLocalitySugestions($id_specimen,$idlocSpElement,$idcountry,$idmunicipality,$idstateprovince,$idDQ);
	$this->UpdateModifyRecordlevelelement($id_specimen);
	///tem que atualizar processo para 1 typexecution 0 sugestion
	
	$criteria = new CDbCriteria;
	$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
	$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>1,'sugestion'=>0),$criteria);
					
	echo CJSON::encode($returnUpdate);
	
}
public function GetCoordinateOutliers($id_specimen) {
	
       //$id_specimen = (int) $_POST['id_specimen'];
       
       $sp=SpecimenAR::model()->with('geospatialelement')->findbyPK($id_specimen);
   	   $idGeoSpElement = $sp->idgeospatialelement;
   	   $geoReturn=GeospatialElementAR::model()->findAllByPk($idGeoSpElement);
   	   
   	   $idlocSpElement = $sp->idlocalityelement;
   	   $locReturn=LocalityElementAR::model()->findAllByPk($idlocSpElement);
   	   
   	   $latitude = $geoReturn[0]->decimallatitude;
   	   $longitude = $geoReturn[0]->decimallongitude;
   	   $municipality_old = $locReturn[0]->idmunicipality;
   	     

		$array_localities = $this->SearchLocality($id_specimen);

		if ($array_localities == -9){
			return -9;			
		}
		

	   	 
	   	   if (sizeof($array_localities)>0){
		   	   $idcountry = $array_localities[0]["idcountry"];
			   $idmunicipality = $array_localities [0]["idmunicipality"];
			   $idstateprovince = $array_localities [0]["idstateprovince"];
			   
			   if ($id_specimen==139){
			   	//print $idmunicipality.' '.$municipality_old;
			   	
			   }
			   if ($idmunicipality!=$municipality_old){
			   	 
		   	 
			   	$returnUpdate = $this->updateLocalityOutliers($id_specimen,$idlocSpElement,$idcountry,$idmunicipality,$idstateprovince);
			   	$this->UpdateModifyRecordlevelelement($id_specimen);
			   	//echo CJSON::encode(1);
			   	return 1;
			   }
			   else {
			   		//procura no log
					    
			   		 	$idDQ = 4;
					    $log_dqAR = Log_dqAR::model()->findByAttributes(
					    array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ));
					    if ($log_dqAR != null){
					    	$result = 1;
					    	return 1;
					    }
					    else {
					    	$result = -1;
					    	return 3;////registro já está certo
					    }
		    
			   	
			   	//echo CJSON::encode(0);
			   }
	   	   //$array_fields [] = array("latitude"=>$latitude,"longitude"=>$longitude);	
	   	   }
	   	   else {return 2; }//não fez nada
	
   	//   }
 	//else {echo CJSON::encode(0);}
   		
}


public function updateLocalitySugestions($id_specimen,$idLocElement,$idcountry,$idmunicipality,$idstateprovince,$idDQ){
			$trans = Yii::app()->db->beginTransaction();
			
			$locReturn=LocalityElementAR::model()->findAllByPk($idLocElement);
   	   
		   	$idcountry_old = $locReturn[0]->idcountry;
		   	$idstateprovince_old = $locReturn[0]->idstateprovince;
		   	$idmunicipality_old = $locReturn[0]->idmunicipality;
		   	   
			$returnUpdate = $this->UpdateLocality($id_specimen,$idLocElement,$idcountry,$idmunicipality,$idstateprovince);
			$this->UpdateModifyRecordlevelelement($id_specimen);
        	
        	 
        	 
        	 if ($returnUpdate>0){
        	 	
        	 	 $deleted_item = $this->insertLogDeletedItems('0','no','0');
	        	 $this->LogInsert($id_specimen,$idDQ,$deleted_item);
	        				           	 
	        	 
	        	   				        	 
	        	 $log_dqAR = Log_dqAR::model()->findByAttributes(
			    	array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ,'undo_log'=>null));
			    
			     $id_log_dq = $log_dqAR->id;
			     	
	        	 $array_fields = array();
	        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'country',"value"=>$idcountry_old);
	        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'municipality',"value"=>$idmunicipality_old);
	        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'stateprovince',"value"=>$idstateprovince_old);
	        	
	        	 
	        	 $returnInsertFields = $this->insertLogFields($array_fields);
	        	 $trans->commit();
	        	 
	        	 return 1;
        	 	
        	 }
        	 else {
        	 	$trans->commit();
        	 	return 0;
        	 }
}


public function updateLocalityOutliers($id_specimen,$idLocElement,$idcountry,$idmunicipality,$idstateprovince){
			$trans = Yii::app()->db->beginTransaction();
			
			$locReturn=LocalityElementAR::model()->findAllByPk($idLocElement);
   	   
		   	$idcountry_old = $locReturn[0]->idcountry;
		   	$idstateprovince_old = $locReturn[0]->idstateprovince;
		   	$idmunicipality_old = $locReturn[0]->idmunicipality;
		   	   
			$returnUpdate = $this->UpdateLocality($id_specimen,$idLocElement,$idcountry,$idmunicipality,$idstateprovince);
			$this->UpdateModifyRecordlevelelement($id_specimen);
        	$idDQ = 4;
        	 
        	 
        	 if ($returnUpdate>0){
        	 	
        	 	 $deleted_item = $this->insertLogDeletedItems('0','no','0');
	        	 $this->LogInsert($id_specimen,$idDQ,$deleted_item);
	        				           	 
	        	 
	        	   				        	 
	        	 $log_dqAR = Log_dqAR::model()->findByAttributes(
			    	array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ,'undo_log'=>null));
			    
			     $id_log_dq = $log_dqAR->id;
			     	
	        	 $array_fields = array();
	        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'country',"value"=>$idcountry_old);
	        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'municipality',"value"=>$idmunicipality_old);
	        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>'stateprovince',"value"=>$idstateprovince_old);
	        	
	        	 
	        	 $returnInsertFields = $this->insertLogFields($array_fields);
	        	 $trans->commit();
	        	 
	        	 return 1;
        	 	
        	 }
        	 else {
        	 	$trans->commit();
        	 	return 0;
        	 }
}

	public function actionSearchNamesLocality(){
		$municipality = (int) $_POST['municipality'];
		$stateprovince = (int) $_POST['stateprovince'];
		$country = (int) $_POST['country'];
		
		$muniReturn=MunicipalityAR::model()->findAllByPk($municipality);
		$nameMunicipality= $muniReturn[0]->municipality;
		
		$stateReturn=StateProvinceAR::model()->findAllByPk($stateprovince);
		$nameStateprovince= $stateReturn[0]->stateprovince;
		
		$countryReturn=CountryAR::model()->findAllByPk($country);
		$nameCountry= $countryReturn[0]->country;
		
		$array_names = array();
		$array_names[0] = $nameMunicipality;
		$array_names[1] = $nameStateprovince;
		$array_names[2] = $nameCountry;
		
		echo CJSON::encode($array_names);
		
		
	}
	
	public function actionGetTaxonHierarchy() {
		
	        $l =  new DataqualityLogic(); 
	       	$rs = $l->searchColHierarchy("Weinmannia pinnata",'Species','col');
	        
	        echo CJSON::encode($rs);
	      
	}
	
	public function GetTaxonHierarchy($name,$taxon) {
		
	        $l =  new DataqualityLogic(); 
	       	$rs = $l->searchColHierarchy($name,$taxon,'col');
	        
	        return $rs;
	      
	}


	public function getIdTaxon($taxon_name_type,$value){
	
				    	
	    $model_class = ucfirst($taxon_name_type).'AR';
		$model = new $model_class ();
		$model_object = $model->findByAttributes(array(($taxon_name_type)=>($value)));
						    	
		$id = 'id'.$taxon_name_type;
		
		return $model_object[$id];
	}
	
	public function colValidationTaxonomicelement($idtaxonomicelement){
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('idtaxonomicelement'.'='.$idtaxonomicelement);
		
		$return = TaxonomicElementAR::model()->updateAll(array('colvalidation'=>'TRUE'),$criteria);
	}
    
	public function updateTaxonomicelement($idtaxonomicelement,$model,$new_id,$old_id,$id_specimen,$idDQ,$log){
		
		$attribute = 'id'.$model;
		//print 'id'.$new_id."</br>";
		//print $idtaxonomicelement."</br>";
		$id = 'id'.$model;
		
		$criteria = new CDbCriteria;
		$criteria->addCondition('idtaxonomicelement'.'='.$idtaxonomicelement);
		$return = TaxonomicElementAR::model()->updateAll(array($id=>$new_id),$criteria);
		$this->UpdateModifyRecordlevelelement($id_specimen);
	
	   		
	    if ($return==1){
	    			 if ($log ==0){
		    			 $deleted_item = $this->insertLogDeletedItems('0','no','0');
			        	 $this->LogInsert($id_specimen,$idDQ,$deleted_item);
			             	   				        	 
			        	 $log_dqAR = Log_dqAR::model()->findByAttributes(
					    	array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ,'undo_log'=>null));
					    
					     $id_log_dq = $log_dqAR->id;
					     	
			        	 $array_fields = array();
			        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>$attribute,"value"=>$old_id);	        	
			        	 
			        	 $returnInsertFields = $this->insertLogFields($array_fields);
	    			 }
	    			 else  if ($log ==1){
	    			 				             	   				        	 
			        	 $log_dqAR = Log_dqAR::model()->findByAttributes(
					    	array('id_specimen'=>$id_specimen,'id_type_log'=>$idDQ,'undo_log'=>null));
					    
					     $id_log_dq = $log_dqAR->id;
					     	
			        	 $array_fields = array();
			        	 $array_fields [] = array("id_log_dq"=>$id_log_dq,"field"=>$attribute,"value"=>$old_id);	        	
			        	 
			        	 $returnInsertFields = $this->insertLogFields($array_fields);
	    			 }
	   			
		        	 
		        	// $returnUpdate = 1;
	    	
            return 1;
	            
		 }
		   else {
		        return -1;
		    }
		
	}
	
	public function actionTaxonHierarchy(){
		$id_specimen = (int) $_POST['id_specimen'];
		$idDQ = (int) $_POST['idDQ'];
		$sugestion = (int) $_POST['sugestion'];
		$sp=SpecimenAR::model()->with('taxonomicelement')->findbyPK($id_specimen);
		$idtaxonomicelement = $sp->idtaxonomicelement;
		
		$return = $this->TaxonHierarchyf($id_specimen,$idDQ,$sugestion);
		if ($idDQ==3){
			$this->colValidationTaxonomicelement($idtaxonomicelement);
			
		}
		echo CJSON::encode($return);
	}
	
	public function TaxonHierarchyf($id_specimen,$idDQ,$sugestion){
		
			//$trans = Yii::app()->db->beginTransaction();
			  
			
			$sugestion = $sugestion?$sugestion-1:0;
			$sp=SpecimenAR::model()->with('taxonomicelement')->findbyPK($id_specimen);
			$idtaxonomicelement = $sp->idtaxonomicelement;
			$idscientificname_sp = $sp->taxonomicelement->idscientificname;
	   		$idgenus_sp = $sp->taxonomicelement->idgenus;
	   		$idfamily_sp = $sp->taxonomicelement->idfamily;
	   		$idorder_sp = $sp->taxonomicelement->idorder;
	   		$idphylum_sp = $sp->taxonomicelement->idphylum;
	   		$idkingdom_sp = $sp->taxonomicelement->idkingdom;
	   		
	   		$log = 0;
	   		
	   			
	   		if ($idscientificname_sp!=null){
	   			$scientificname = ScientificNameAR::model()->findbyPK($idscientificname_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($scientificname->scientificname,'Species');
	   		}	
	   		else 
			if ($idgenus_sp!=null){
	   			$genus = GenusAR::model()->findbyPK($idgenus_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($genus->genus,'Genus');
	   		}
			else 
			if ($idfamily_sp!=null){
	   			$family = FamilyAR::model()->findbyPK($idfamily_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($family->family,'Family');
	   		}	
	   		else 
			if ($idorder_sp!=null){
	   			$order = OrderAR::model()->findbyPK($idorder_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($order->order,'Order');
	   		}	
	   		else 
			if ($idphylum_sp!=null){
	   			$phylum = PhylumAR::model()->findbyPK($idphylum_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($phylum->phylum,'Phylum');
	   		}	
	   		else 
			if ($idkingdom_sp!=null){
	   			$kingdom = KingdomAR::model()->findbyPK($idkingdom_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($kingdom->kingdom,'Kingdom');
	   		}	
	   		
	   			
	   			if($colHierarchy!=null){
	   				
	   				//$pieces = explode("},", $colHierarchy);
	   				$returnUpdate = 0;
	   				foreach ($colHierarchy[$sugestion] as $taxon){
	   						if ($taxon['taxon'] == 'Genus'){
	   							$idCol = 0;
	   							$nameCol = $taxon['name'];
	   							$model = 'genus';
	   							$idCol = $this->getIdTaxon($model,$nameCol);
	   							$returnUpdate = 0;
	   							$attribute = 'id'.$model;
	   							
	   							
	   							
	   						    //se não existir cria o taxon name e pega o id
		   						if ($idCol==null){
		   								
		   								$class = $model.'AR';
		   								$model_save = new $class();
							   		 	$model_save->$model = $nameCol;
							   		 	$model_save->colvalidation = 't';
							   		 	$model_save = $model_save->Save();
							   		 	$idCol = $model_save->$attribute;
	   		 	
		   								
		   						}
		   							
		   							
	   							$genus = GenusAR::model()->findByAttributes(
		    								array('genus'=>$nameCol));
		    
	   							$idCol = $genus->idgenus;
	   							$id_bd = $idgenus_sp;
	   							
	   							
	   							if (($id_bd == 0)||($idDQ==3)){
	   								
		 
	   								$returnUpdate = $this->updateTaxonomicelement($idtaxonomicelement,$model,$idCol,$id_bd,$id_specimen,$idDQ,$log);  
	   								$log = 1;
	   							}
	   							
	   							//echo CJSON::encode($returnUpdate);
	   						}
	   					
	   					
	   					   else if ($taxon['taxon'] == 'Family'){
	   							$idCol = 0;
	   							$nameCol = $taxon['name'];
	   							$model = 'family';
	   							$idCol = $this->getIdTaxon($model,$nameCol);
	   							$returnUpdate = 0;
	   							$attribute = 'id'.$model;
	   							
	   						    //se não existir cria o taxon name e pega o id
		   						if ($idCol==null){
		   								
		   								$class = $model.'AR';
		   								$model_save = new $class();
							   		 	$model_save->$model = $nameCol;
							   		 	$model_save->colvalidation = 't';
							   		 	$model_save = $model_save->Save();
							   		 	$idCol = $model_save->$attribute;
	   		 	
		   								
		   						}
		   							
		   						
		   						$family = FamilyAR::model()->findByAttributes(
		    								array('family'=>$nameCol));
		    
	   							$idCol = $family->idfamily;
	   							$id_bd = $family_sp;
	   							
	   							if (($id_bd == 0)||($idDQ==3)){
	   								$returnUpdate = $this->updateTaxonomicelement($idtaxonomicelement,$model,$idCol,$id_bd,$id_specimen,$idDQ,$log);  
	   								$log = 1;
	   							}
	   							
	   							//echo CJSON::encode($returnUpdate);
	   						}
	   						else if ($taxon['taxon'] == 'Order'){
	   							    $idCol = 0;
		   							$nameCol = $taxon['name'];
		   							$model = 'order';
		   							$idCol = $this->getIdTaxon($model,$nameCol);
		   							$attribute = 'id'.$model;
		   							
		   							//se não existir cria o taxon name e pega o id
		   							if ($idCol==null){
		   								
		   								$class = $model.'AR';
		   								$model_save = new $class();
							   		 	$model_save->$model = $nameCol;
							   		 	$model_save->colvalidation = 't';
							   		 	$model_save = $model_save->Save();
							   		 	$idCol = $model_save->$attribute;
	   		 	
		   								
		   							}
		   							
		   							$order = OrderAR::model()->findByAttributes(
		    								array('order'=>$nameCol));
		    
	   								$idCol = $order->idorder;
		   							$id_bd = $order_sp;
		   							
		   							if (($id_bd == 0)||($idDQ==3)){
		   								$returnUpdate = $this->updateTaxonomicelement($idtaxonomicelement,$model,$idCol,$id_bd,$id_specimen,$idDQ,$log);  
	   									$log = 1;
		   							}
		   							
		   							//echo CJSON::encode($returnUpdate);
	   						}
	   						else if ($taxon['taxon'] == 'Class'){
	   							    $idCol = 0;
		   							$nameCol = $taxon['name'];
		   							$model = 'class';
		   							$idCol = $this->getIdTaxon($model,$nameCol);
		   							//$returnUpdate = 0;
		   							$attribute = 'id'.$model;
		   							
	   								//se não existir cria o taxon name e pega o id
		   							if ($idCol==null){
		   								
		   								$class = $model.'AR';
		   								$model_save = new $class();
							   		 	$model_save->$model = $nameCol;
							   		 	$model_save->colvalidation = 't';
							   		 	$model_save = $model_save->Save();
							   		 	$idCol = $model_save->$attribute;
	   		 	
		   								
		   							}
		   						
		   							$class = ClassAR::model()->findByAttributes(
		    								array('class'=>$nameCol));
		    
	   								$idCol = $class->idclass;
	   								$id_bd = $class_sp;	
		   							
		   							if (($id_bd == 0)||($idDQ==3)){
		   								//echo $attribute;
		   								$returnUpdate = $this->updateTaxonomicelement($idtaxonomicelement,$model,$idCol,$id_bd,$id_specimen,$idDQ,$log);  
	   									$log = 1;
		   							}
		   							//echo CJSON::encode($returnUpdate);
	   						}
	   						else if ($taxon['taxon'] == 'Phylum'){
	   							    $idCol = 0;
		   							$nameCol = $taxon['name'];
		   							$model = 'phylum';
		   							$idCol = $this->getIdTaxon($model,$nameCol);
		   							//$returnUpdate = 0;
		   							$attribute = 'id'.$model;
		   							
		   							//se não existir cria o taxon name e pega o id
		   							if ($idCol==null){
		   								
		   								$class = $model.'AR';
		   								$model_save = new $class();
							   		 	$model_save->$model = $nameCol;
							   		 	$model_save->colvalidation = 't';
							   		 	$model_save = $model_save->Save();
							   		 	$idCol = $model_save->$attribute;
	   		 	
		   								
		   							}
		   						
		   							$phylum = PhylumAR::model()->findByAttributes(
		    								array('phylum'=>$nameCol));
		    
	   								$idCol = $phylum->idphylum;
		   							$id_bd = $phylum_sp;	
		   							
		   							if (($id_bd == 0)||($idDQ==3)){
		   								$returnUpdate = $this->updateTaxonomicelement($idtaxonomicelement,$model,$idCol,$id_bd,$id_specimen,$idDQ,$log);  
	   									$log = 1;
		   							}
		   							
		   							//echo CJSON::encode($returnUpdate);
	   						}
	   						
	   						else if ($taxon['taxon'] == 'Kingdom'){
	   							    $idCol = 0;
		   							$nameCol = $taxon['name'];
		   							$model = 'kingdom';
		   							$idCol = $this->getIdTaxon($model,$nameCol);
		   							//$returnUpdate = 0;
		   							$attribute = 'id'.$model;
		   							
		   							//se não existir cria o taxon name e pega o id
		   							if ($idCol==null){
		   								
		   								$class = $model.'AR';
		   								$model_save = new $class();
							   		 	$model_save->$model = $nameCol;
							   		 	$model_save->colvalidation = 't';
							   		 	$model_save = $model_save->Save();
							   		 	$idCol = $model_save->$attribute;
	   		 	
		   								
		   							}
		   						
		   							
		   							$kingdom = KingdomAR::model()->findByAttributes(
		    								array('kingdom'=>$nameCol));
		    
	   								$idCol = $kingdom->idkingdom;
		   							$id_bd = $kingdom_sp;
		   							
		   							if (($id_bd == 0)||($idDQ==3)){
		   								$returnUpdate = $this->updateTaxonomicelement($idtaxonomicelement,$model,$idCol,$id_bd,$id_specimen,$idDQ,$log);  
	   									$log = 1;
		   							}
		   							
		   							//echo CJSON::encode($returnUpdate);
	   						}
	   						
	   						
	   						
	   				}
	   				
	   				if ($log==1){
	   					$criteria = new CDbCriteria;
						$criteria->addCondition('id_specimen'.'='.$id_specimen.' and id_type_dq='.$idDQ);
						$success_update = ProcessSpecimensExecutionAR::model()->updateAll(array('type_execution'=>1,'sugestion'=>0),$criteria);
	   					$this->UpdateModifyRecordlevelelement($id_specimen);
	   					//$trans->commit();	
	   					return 1; //correct
	   					
	   				}
	   			}
	   			else {
	   				//$trans->commit();	
	   				return 2; //detect
	   				
	   			}
	   		/*}else {
	   				//$trans->commit();	
	   				return 2; //detect
	   				
	   			}*/
	   		
	
	   		
	   		
   		
		 
	}  
	
	public function actionGetColTaxonHierarchy(){
		
			$id_specimen = (int) $_POST['id_specimen'];
			$idDQ = (int) $_POST['idDQ'];
			
			   		
			$sp=SpecimenAR::model()->with('taxonomicelement')->findbyPK($id_specimen);
			$idtaxonomicelement = $sp->idtaxonomicelement;
			$idscientificname_sp = $sp->taxonomicelement->idscientificname;
	   		$idgenus_sp = $sp->taxonomicelement->idgenus;
	   		$idfamily_sp = $sp->taxonomicelement->idfamily;
	   		$idorder_sp = $sp->taxonomicelement->idorder;
	   		$idphylum_sp = $sp->taxonomicelement->idphylum;
	   		$idkingdom_sp = $sp->taxonomicelement->idkingdom;
	   		
	   		$log = 0;
	   		
	   		if ($idscientificname_sp!=null){
	   			$scientificname = ScientificNameAR::model()->findbyPK($idscientificname_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($scientificname->scientificname,'Species');
	   		}	
	   		else 
			if ($idgenus_sp!=null){
	   			$genus = GenusAR::model()->findbyPK($idgenus_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($genus->genus,'Genus');
	   		}
			else 
			if ($idfamily_sp!=null){
	   			$family = FamilyAR::model()->findbyPK($idfamily_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($family->family,'Family');
	   		}	
	   		else 
			if ($idorder_sp!=null){
	   			$order = OrderAR::model()->findbyPK($idorder_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($order->order,'Order');
	   		}	
	   		else 
			if ($idphylum_sp!=null){
	   			$phylum = PhylumAR::model()->findbyPK($idphylum_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($phylum->phylum,'Phylum');
	   		}	
	   		else 
			if ($idkingdom_sp!=null){
	   			$kingdom = KingdomAR::model()->findbyPK($idkingdom_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($kingdom->kingdom,'Kingdom');
	   		}	
	   		
	   		
	   		
	   		if($colHierarchy!=null){
				
	   		for ($i=0;$i<sizeof($colHierarchy);$i++){
	   			foreach ($colHierarchy[$i] as $taxon){
	   						if ($taxon['taxon'] == 'Genus'){
	   							
	   							$col_Hierarchy[$i] = array ('genus'=>$taxon['name']);
	   						}
	   						else 
	   						if ($taxon['taxon'] == 'Family'){
	   							
	   							$col_Hierarchy[$i] = array ('family'=>$taxon['name']);
	   						}
	   						else 
	   						if ($taxon['taxon'] == 'Order'){
	   							
	   							$col_Hierarchy[$i] = array ('order'=>$taxon['name']);
	   						}
	   						else 
	   						if ($taxon['taxon'] == 'Class'){
	   							
	   							$col_Hierarchy[$i] = array ('class'=>$taxon['name']);
	   						}
	   						else 
	   						if ($taxon['taxon'] == 'Phylum'){
	   							
	   							$col_Hierarchy[$i] = array ('phylum'=>$taxon['name']);
	   						}
	   						else 
	   						if ($taxon['taxon'] == 'Kingdom'){
	   							
	   							$col_Hierarchy[$i] = array ('kingdom'=>$taxon['name']);
	   						}
	   						
	   						
	   						
	   			}
	   		}
	   			
	   		
		    
		    echo CJSON::encode($colHierarchy);
		    
	   		}
	   		else {
	   			 echo CJSON::encode(0);
	   		}
			    	
	   		
	}
	
	public function CheckTaxonHierarchy($id_specimen){
		
			$trans = Yii::app()->db->beginTransaction();
			  
			//$id_specimen = (int) $_POST['id_specimen'];
			$idDQ = 3;
			
			$sp=SpecimenAR::model()->with('taxonomicelement')->findbyPK($id_specimen);
			$idtaxonomicelement = $sp->idtaxonomicelement;
			$idscientificname_sp = $sp->taxonomicelement->idscientificname;
	   		$idgenus_sp = $sp->taxonomicelement->idgenus;
	   		$idfamily_sp = $sp->taxonomicelement->idfamily;
	   		$idorder_sp = $sp->taxonomicelement->idorder;
	   		$idphylum_sp = $sp->taxonomicelement->idphylum;
	   		$idkingdom_sp = $sp->taxonomicelement->idkingdom;
	   		
	   		$log = 0;
	   		
	   		if ($idscientificname_sp!=null){
	   			$scientificname = ScientificNameAR::model()->findbyPK($idscientificname_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($scientificname->scientificname,'Species');
	   		}	
	   		else 
			if ($idgenus_sp!=null){
	   			$genus = GenusAR::model()->findbyPK($idgenus_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($genus->genus,'Genus');
	   		}
			else 
			if ($idfamily_sp!=null){
	   			$family = FamilyAR::model()->findbyPK($idfamily_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($family->family,'Family');
	   		}	
	   		else 
			if ($idorder_sp!=null){
	   			$order = OrderAR::model()->findbyPK($idorder_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($order->order,'Order');
	   		}	
	   		else 
			if ($idphylum_sp!=null){
	   			$phylum = PhylumAR::model()->findbyPK($idphylum_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($phylum->phylum,'Phylum');
	   		}	
	   		else 
			if ($idkingdom_sp!=null){
	   			$kingdom = KingdomAR::model()->findbyPK($idkingdom_sp);
	   			$colHierarchy = $this->GetTaxonHierarchy($kingdom->kingdom,'Kingdom');
	   		}	
	   		
	   			$dif = 0;
	   			$arrary_colHierarchy = array();
	   			if($colHierarchy!=null){
	   				//$pieces = explode("},", $colHierarchy);
	   				$returnUpdate = 0;
	   				foreach ($colHierarchy[0] as $taxon){
	   						if ($taxon['taxon'] == 'Genus'){
	   							$idCol = 0;
	   							$nameCol = $taxon['name'];
	   							$model = 'genus';
	   							$idCol = $this->getIdTaxon($model,$nameCol);
	   							$returnUpdate = 0;
	   							$attribute = 'id'.$model;
	   							
	   						    //se não existir cria o taxon name e pega o id
		   						if ($idCol==null){
		   								
		   								$class = $model.'AR';
		   								$model_save = new $class();
							   		 	$model_save->$model = $nameCol;
							   		 	$model_save->colvalidation = 't';
							   		 	$model_save = $model_save->Save();
							   		 	$idCol = $model_save->$attribute;
	   		 	
		   								
		   						}
		   							
		   							
	   							$id_bd = (int) $sp->taxonomicelement->$attribute;
	   							$arrary_colHierarchy [] = array($taxon['taxon']=>$taxon['name']);
	   							if ($id_bd !=$idCol){
	   								$dif = 1;  
	   								
	   								
	   							}
	   							
	   							//echo CJSON::encode($returnUpdate);
	   						}
	   					
	   					
	   					   else if ($taxon['taxon'] == 'Family'){
	   							$idCol = 0;
	   							$nameCol = $taxon['name'];
	   							$model = 'family';
	   							$idCol = $this->getIdTaxon($model,$nameCol);
	   							$returnUpdate = 0;
	   							$attribute = 'id'.$model;
	   							
	   						    //se não existir cria o taxon name e pega o id
		   						if ($idCol==null){
		   								
		   								$class = $model.'AR';
		   								$model_save = new $class();
							   		 	$model_save->$model = $nameCol;
							   		 	$model_save->colvalidation = 't';
							   		 	$model_save = $model_save->Save();
							   		 	$idCol = $model_save->$attribute;
	   		 	
		   								
		   						}
		   							
		   							
	   							$id_bd = $sp->taxonomicelement->$attribute;
	   							$arrary_colHierarchy [] = array($taxon['taxon']=>$taxon['name']);
	   							
	   					   		if ($id_bd !=$idCol){
	   								$dif = 1;  
	   								
	   								
	   							}
	   							
	   							//echo CJSON::encode($returnUpdate);
	   						}
	   						else if ($taxon['taxon'] == 'Order'){
	   							    $idCol = 0;
		   							$nameCol = $taxon['name'];
		   							$model = 'order';
		   							$idCol = $this->getIdTaxon($model,$nameCol);
		   							$attribute = 'id'.$model;
		   							
		   							//se não existir cria o taxon name e pega o id
		   							if ($idCol==null){
		   								
		   								$class = $model.'AR';
		   								$model_save = new $class();
							   		 	$model_save->$model = $nameCol;
							   		 	$model_save->colvalidation = 't';
							   		 	$model_save = $model_save->Save();
							   		 	$idCol = $model_save->$attribute;
	   		 	
		   								
		   							}
		   							
		   							$id_bd = $sp->taxonomicelement->$attribute;
		   							
		   							$arrary_colHierarchy [] = array($taxon['taxon']=>$taxon['name']);
		   							
			   						if ($id_bd !=$idCol){
			   								$dif = 1;  
			   								
			   								
			   							}
		   							
		   							//echo CJSON::encode($returnUpdate);
	   						}
	   						else if ($taxon['taxon'] == 'Class'){
	   							    $idCol = 0;
		   							$nameCol = $taxon['name'];
		   							$model = 'class';
		   							$idCol = $this->getIdTaxon($model,$nameCol);
		   							//$returnUpdate = 0;
		   							$attribute = 'id'.$model;
		   							
	   								//se não existir cria o taxon name e pega o id
		   							if ($idCol==null){
		   								
		   								$class = $model.'AR';
		   								$model_save = new $class();
							   		 	$model_save->$model = $nameCol;
							   		 	$model_save->colvalidation = 't';
							   		 	$model_save = $model_save->Save();
							   		 	$idCol = $model_save->$attribute;
	   		 	
		   								
		   							}
		   							$arrary_colHierarchy [] = array($taxon['taxon']=>$taxon['name']);
		   						
		   							$id_bd = $sp->taxonomicelement->$attribute;
		   							
			   						if ($id_bd !=$idCol){
			   								$dif = 1;  
			   								
			   								
			   							}
	   						}
	   						else if ($taxon['taxon'] == 'Phylum'){
	   							    $idCol = 0;
		   							$nameCol = $taxon['name'];
		   							$model = 'phylum';
		   							$idCol = $this->getIdTaxon($model,$nameCol);
		   							//$returnUpdate = 0;
		   							$attribute = 'id'.$model;
		   							
	   								//se não existir cria o taxon name e pega o id
		   							if ($idCol==null){
		   								
		   								$class = $model.'AR';
		   								$model_save = new $class();
							   		 	$model_save->$model = $nameCol;
							   		 	$model_save->colvalidation = 't';
							   		 	$model_save = $model_save->Save();
							   		 	$idCol = $model_save->$attribute;
	   		 	
		   								
		   							}
		   							
		   							$id_bd = $sp->taxonomicelement->$attribute;
		   							$arrary_colHierarchy [] = array($taxon['taxon']=>$taxon['name']);
		   							
			   						if ($id_bd !=$idCol){
			   								$dif = 1;  
			   								
			   								
			   							}
	   						}
	   						
	   						else if ($taxon['taxon'] == 'Kingdom'){
	   							    $idCol = 0;
		   							$nameCol = $taxon['name'];
		   							$model = 'kingdom';
		   							$idCol = $this->getIdTaxon($model,$nameCol);
		   							//$returnUpdate = 0;
		   							$attribute = 'id'.$model;
		   							
	   						//se não existir cria o taxon name e pega o id
		   							if ($idCol==null){
		   								
		   								$class = $model.'AR';
		   								$model_save = new $class();
							   		 	$model_save->$model = $nameCol;
							   		 	$model_save->colvalidation = 't';
							   		 	$model_save = $model_save->Save();
							   		 	$idCol = $model_save->$attribute;
	   		 	
		   								
		   							}
		   							
		   							$id_bd = $sp->taxonomicelement->$attribute;
		   							
		   							$arrary_colHierarchy [] = array($taxon['taxon']=>$taxon['name']);
		   							
			   						if ($id_bd !=$idCol){
			   								$dif = 1; 
			   								 
			   								
			   							}
	   						}
	   						
	   						
	   						
	   				}
	   				
	   				if ($dif==1){
	   					$this->colValidationTaxonomicelement($idtaxonomicelement);
   						$trans->commit();
	   					return 2; //detect/sugest
	   					
	   				}else {
	   					$trans->commit();
	   					return 0; //nao faz nada está certa a hierarquia
	   				}
	   			}
	   			else {
	   				$trans->commit();
	   				return 3; //só marca que está errado
	   				
	   			}
	   		/*}else {
	   			$trans->commit();
	   				return 3; //só marca que está errado
	   				
	   			}*/
	   		
	
	   			
	   		
   		
		 
	} 
	
	public function actionFilterTaxonHierarchy() {
    	$idDQ = (int) $_POST['idDQ'];
        $l = new DataqualityLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list'], 'arrayOut'=>$_POST['arrayOut']);
        $rs = array();
        $rs = array();

        $spList = $l->filter($idDQ,$filter); 
        $list = array();
        //print_r($spList);
        $retOutliers = 0;
        if (is_array($spList)){
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
			            	"scientificname" => $ar['scientificname'],
		            		"latitude" => $ar['latitude'],
		            		"longitude" => $ar['longitude'],
		            		"country" => $ar['country'],
				            "stateprovince" => $ar['stateprovince'],
				            "municipality" => $ar['municipality'],
		            		"idcountry" => $ar['idcountry'],
				            "idstateprovince" => $ar['idstateprovince'],
				            "idmunicipality" => $ar['idmunicipality'],
			            	"geodeticdatum" => $ar['geodeticdatum'],
		            		"coordinateuncertaintyinmeters" => $ar['coordinateuncertaintyinmeters']
		               
		            		          
		            		
		            );
		        
	        }
        }   
	        
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    
    
    function actionGetLocalTaxonHierarchy(){
    				$id_specimen = (int) $_POST['id_specimen'];
					$idDQ = (int) $_POST['idDQ'];
   					$sp=SpecimenAR::model()->with('taxonomicelement')->findbyPK($id_specimen);
			     	$idtaxonomicelement = $sp->idtaxonomicelement;
			   		
			     	$tx=TaxonomicElementAR::model()->with('genus')->with('family')->with('order')->with('class')->with('phylum')->with('kingdom')->findbyPK($idtaxonomicelement);
			     	
			     	$ngenus = $tx->genus->genus;
			     	$nfamily = $tx->family->family;
			     	$norder = $tx->order->order;
			     	$nclass = $tx->class->class;
			     	$nphylum = $tx->phylum->phylum;
			     	$nkingdom = $tx->kingdom->kingdom;
			     
			     	$localTaxonHierarchy = array();
			    	$localTaxonHierarchy[] = array ('genus'=>$ngenus,'family'=>$nfamily ,'order'=>$norder, 'class'=>$nclass, 'phylum'=>$nphylum, 'kingdom'=>$nkingdom);	
			    	
			    	echo CJSON::encode($localTaxonHierarchy);
    }
    
    
    
    //////process
    
	public function filterAll($idDQ) {
    	///$idDQ = (int) $_POST['idDQ'];
        $l = new DataqualityLogic();
        $filter = array('limit'=>null,'offset'=>0,'list'=>null);
        $rs = array();

        $spList = $l->filter($idDQ,$filter); 
        $list = array();
       // print_r($spList);
        if (is_array($spList)){
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
			            	"scientificname" => $ar['scientificname'],
		            		"latitude" => $ar['latitude'],
		            		"longitude" => $ar['longitude'],
		            		"country" => $ar['country'],
				            "stateprovince" => $ar['stateprovince'],
				            "municipality" => $ar['municipality'],
		            		"idcountry" => $ar['idcountry'],
				            "idstateprovince" => $ar['idstateprovince'],
				            "idmunicipality" => $ar['idmunicipality'],
			            	"geodeticdatum" => $ar['geodeticdatum'],
		            		"coordinateuncertaintyinmeters" => $ar['coordinateuncertaintyinmeters']
		               
		            		          
		            		
		            );
		        
	        }
        }
        
        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        return $rs;
    }
    
	public function searchProcess(){
			$process = ProcessLogdqAR::model()->findByAttributes(
		    array('date_finish'=>null,'time_finish'=>null));
		    if ($process != null){
		    	$result = 1;
		    	return $process->id;
		    }
		    else {
		    	return 0;
		    }
    	
    }
    
    public function createProcess(){
    	    $process = new ProcessLogdqAR();
            $process->id_user = Yii::app()->user->id;
            $process->date_start = date('Y-m-d');
            $process->time_start = date('H:i:s');
            $process->id_last_task = 1;
           	$process->save();
           //	$process->id;
           	return $process->id;
           	
    	
    }
    
	
    
   public function insertSpecimenProcessExecution($idDQ,$id_specimen,$id_process,$type,$sugestion){
    	    $process_execution = new ProcessSpecimensExecutionAR();
            $process_execution->id_type_dq = $idDQ;
            $process_execution->id_specimen = $id_specimen;
            $process_execution->id_process = $id_process;
            $process_execution->type_execution = $type;
             $process_execution->sugestion = $sugestion;
           	$process_execution->save();
           //	$process->id;
           	return $process->id;
    	
    
	}
	
  public function insertTaxonProcessExecution($idDQ,$id_taxon,$id_process,$value,$id_taxon_type,$type,$sugestion,$id_taxon){
    	    $process_execution = new ProcessTaxonExecutionAR();
            $process_execution->id_type_dq = $idDQ;
            $process_execution->id_taxon = $id_taxon;
            $process_execution->id_process = $id_process;
            $process_execution->name_taxon = $value;
             $process_execution->id_taxon_type = $id_taxon_type;
            $process_execution->type_execution = $type;
            $process_execution->sugestion = $sugestion;
           	$process_execution->save();
           //	$process->id;
           	return $process->id;
    	
  
  
  
	}
	
	function  updateTaskProcess($process_id, $task){
		  $Return=ProcessLogdqAR::model()->updateByPk($process_id,array('id_last_task'=>$task));
    	  return $Return;
		
	}

	public function tasks($idDQ,$process_id){
						
    
    					
    				  if ($idDQ == 1){ //coordenadas
			              $list_specimens = $this->filterAll($idDQ);
	    					    						
	    					if (is_array($list_specimens)){
	    						foreach($list_specimens['result'] as $l){
	    							$id_specimen = $l['id'];
	    							$return = $this->Coordinates($id_specimen);
	    							
	    							
	    							if ($return == -9){
	    								
	    								return -9;//estourou consultas google
	    								
	    							}
	    							
	    							if ($return==1){
	    								///adiciona registro de correção
	    								$type = 1;
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    								$this->UpdateModifyRecordlevelelement($id_specimen);
	    								
	    							}
	    							else if ($return==2){
	    								$type = 2;
	    								///adiciona registro de deteccao
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    								
	    							}
	    							else if (is_array($return)){
	    								$type = 2;
	    								///adiciona registro de deteccao
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,1);
	    								
	    							}
	    							
	    							
	    						}
    					}
    					$this->updateTaskProcess($process_id, 1);
	
				}
				
				else if ($idDQ == 4){ //outiliers
					
			              $list_specimens = $this->filterAll($idDQ);
	    					//echo CJSON::encode($list_specimens);
	    					
	    					//echo CJSON::encode($list_specimens);
	    						
	    					if (is_array($list_specimens)){
	    						foreach($list_specimens['result'] as $l){
	    							$id_specimen = $l['id'];
	    							$return = $this->GetCoordinateOutliers($id_specimen);
	    							
	    							if ($return == -9){
	    								
	    								return -9;//estourou consultas google
	    								
	    							}
	    							
	    							//print $return;
	    							if ($return==1){
	    								///adiciona registro de correção
	    								$type = 1;
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    								
	    							}
	    							else if ($return==2){
	    								$type = 2;
	    								///adiciona registro de deteccao
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    								
	    							}
	    							else if ($return==3){
	    								$type = 0;
	    								///adiciona registro que foi testado mas esta certo não aparece na listagem
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    								
	    							}
	    							
	    							
	    						}
    					}
    					$this->updateTaskProcess($process_id, 4);
	
				}
				
			else if ($idDQ == 8){ //datum
					
			              $list_specimens = $this->filterAll($idDQ);
	 	    			  
	    					if (is_array($list_specimens)){
	    						foreach($list_specimens['result'] as $l){
	    							$id_specimen = $l['id'];
	    							$return = $this->Datum($id_specimen);
	    							
	    							if ($return==1){
	    								///adiciona registro de correção
	    								$type = 1;
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    								
	    							}
	    							else if ($return==2){
	    								$type = 2;
	    								///adiciona registro de deteccao
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    								
	    							}
	    							
	    							
	    							
	    						}
    					}
    					else {
    						echo 'vazio';
    					}
    					$this->updateTaskProcess($process_id, 8);
	
				}
		else if ($idDQ == 7){ //incerteza
					
			              $list_specimens = $this->filterAll($idDQ);
	    					//echo CJSON::encode($list_specimens);

	    					if (is_array($list_specimens)){
	    						foreach($list_specimens['result'] as $l){
	    							    $id_specimen = $l['id'];
	    								$type = 2;
	    								///adiciona registro de deteccao
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    							
	    						}
    					}
    					$this->updateTaskProcess($process_id, 7);
	
				}
		else if ($idDQ == 5){ //locality
					
			              $list_specimens = $this->filterAll($idDQ);
	    	
	    					if (is_array($list_specimens)){
	    						foreach($list_specimens['result'] as $l){
	    							$id_specimen = $l['id'];
	    							$return = $this->Locality($id_specimen);
	    							
	    							if ($return == -9){
	    								
	    								return -9;//estourou consultas google
	    								
	    							}
	    							
	    							if ($return==1){
	    								///adiciona registro de correção
	    								$type = 1;
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    								
	    							}
	    							else if ($return==2){
	    								$type = 2;
	    								///adiciona registro de deteccao
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    								
	    							}
	    							
	    							
	    							
	    						}
    					}
    					$this->updateTaskProcess($process_id, 5);
	
				}
	else if ($idDQ == 6){ //Nomes menos especificos
					
			              $list_specimens = $this->filterAll($idDQ);
	    		    						
	    					if (is_array($list_specimens)){
	    						foreach($list_specimens['result'] as $l){
	    							$id_specimen = $l['id'];
	    							$return = $this->TaxonHierarchyf($id_specimen,$idDQ,'');
	    							
	    							if ($return==1){
	    								///adiciona registro de correção
	    								$type = 1;
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    								
	    							}
	    							else if ($return==2){
	    								$type = 2;
	    								///adiciona registro de deteccao
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    								
	    							}
	    							
	    							
	    							
	    							
	    						}
    					}
    					$this->updateTaskProcess($process_id, 6);
	
				}
	else if ($idDQ == 3){ //hierarquia errada
					
			              $list_specimens = $this->filterAll($idDQ);
	    				    						
	    					if (is_array($list_specimens)){
	    						foreach($list_specimens['result'] as $l){
	    							$id_specimen = $l['id'];
	    							$return = $this->CheckTaxonHierarchy($id_specimen);
	    							
	    							if ($return==2){
	    								$type = 2;
	    								///adiciona registro de deteccao
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,1);
	    								
	    							}
	    							else if ($return==0){
	    								$type = 0;
	    								///registros certos
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,0);
	    								
	    							}
	    							else if ($return==3){
	    								$type = 3;
	    								///adiciona registro de deteccao
	    								$this->insertSpecimenProcessExecution($idDQ,$id_specimen,$process_id,$type,1);
	    								
	    							}
	    							
	    							
	    							
	    						}
    					}
    					$this->updateTaskProcess($process_id, 3);
	
				}
				
	else if ($idDQ == 2){ //taxons errados
					
			                
			                $sugestion = 1;
			                
			                for ($i=1; $i<8; $i++){
			                	
			                	
					                $id_taxon_type = $i;
									$list = $this->filterTaxonf($id_taxon_type);
									if (is_array($list)){
										foreach($list['result'] as $l){
											
											$id_taxon = $l['id'];
											$value = $l['value'];

											$taxonTypeName = $this->getTaxonTypeName($id_taxon_type);
											
											
											//procura no col
								        	$res_col = $this->ColEqual($l['value'],$taxonTypeName);
								        	
								        	//procura se foi feita alguma correcao que pode ser desfeita
										
								        	if ($res_col==0){
								        		$atributo = 'id'.strtolower($taxonTypeName);
								        		//verifica se tem especies - se nao tiver exclui
								        		$sp = TaxonomicElementAR::model()->findByAttributes(
		  										  array($atributo=>$id_taxon));
								        		
		  										  
								        		
								        		if ($sp){
									           		 ///adiciona registro de deteccao
													$this->insertTaxonProcessExecution($idDQ,$id_taxon,$process_id,$value,$id_taxon_type,2,$sugestion,$id_taxon);
								        		}
								        		else {
								        			///exclui
								        			$class = ucfirst($taxonTypeName).'AR';
			 	 									$object_model = new $class ();
								        			$success_delete = $object_model->deleteByPk($id_taxon);
			   						    	    								        		
					    							
			        							}
								        	}
			        						else {
			        							///adiciona registro que tem correspondencia com o col
												$this->insertTaxonProcessExecution($idDQ,$id_taxon,$process_id,$value,$id_taxon_type,0,$sugestion,$id_taxon);
					    						
			        							
			        						}
	        	
			    							
										
										}
										
									}
			                	
			                }
							
						
					$this->updateTaskProcess($process_id, 2);
			                
				}
				
			$this->UpdateProcess($process_id);
			return 1;
	}
	
	public function UpdateProcess($process_id){
			 //$process_id = $_POST['process_id'];
    	     $Return=ProcessLogdqAR::model()->updateByPk($process_id,array('date_finish'=>date('Y-m-d'),'time_finish'=>date('H:i:s'), ));
    	     $process = $this->getProcessInformationf();
 			 return proces; 

    }
		
	public function actionDoTask(){
		
		
		$task = $_POST['task'];
		$process_id=$_POST['process_id'];
		
		$return = $this->tasks($task,$process_id);
		
		echo CJSON::encode($return);
		
	}
	
	
	public function actionStartProcess(){
		$process_id = $this->createProcess();
		
		echo CJSON::encode($process_id);
	}
 
    					
    					
			    	
  
    
    public function actionGetCoordinates(){
    	$idDQ = (int) $_POST['idDQ'];
    	$id_specimen = (int) $_POST['id_specimen'];
		$sp=SpecimenAR::model()->with('localityelement')->findbyPK($id_specimen);
   		$idGeoSpElement = $sp->idgeospatialelement;
   		
   		$geospatialElement=GeospatialElementAR::model()->findbyPK($idGeoSpElement);
        $latitude= (float) $geospatialElement->decimallatitude;
        $longitude = (float) $geospatialElement->decimallongitude;
   		
        $Coordinates = array();
    	$Coordinates [] = array ('latitude'=>$latitude, 'longitude'=>$longitude);
			    	
		echo CJSON::encode($Coordinates);
			    	
    }
    
    public function searchLastProcess(){
    	$criteria = new CDbCriteria();
		//$criteria->with = array('users');
		$criteria->addCondition('date_finish IS NOT NULL and time_finish IS NOT NULL');
		$criteria->order = 'id DESC';
		$process = ProcessLogdqAR::model()->with('users')->findAll($criteria);
		return $process[0];
    	
    }
    
	public function getProcessInformationf(){
    		$process = $this->searchLastProcess();
    		$user = $process->users->username;
    		$criteria = new CDbCriteria();
			$criteria->addCondition('id_process = '.$process->id);
		
			if ($process){
	    		$process_rows = ProcessSpecimensExecutionAR::model()->findAll($criteria);
	    		
	    		$process_array = array();
	    		$process_array [] = array ('id'=>$process->id, 
	    								'start'=>date("d-m-Y",strtotime($process->date_start)).' '.$process->time_start,
	    		 						'finish'=>date("d-m-Y",strtotime($process->date_finish)).' '.$process->time_finish,
	    								'user'=>$user,
	    								'nSP'=>sizeof($process_rows)
	    							);
	    	
	    		
	    		return ($process_array);
			}
			else {
				return 0;
				
			}
    }
    
    public function actionGetProcessInformation(){
    		
    		$process_array = $this->getProcessInformationf();
    		
    		echo CJSON::encode($process_array);
    }
    
	public function actionSearch() {
        $logic = new SpecimenLogic();
        $rs = $logic->search($_GET['term']);
        echo CJSON::encode($rs);
    }
    
    public function actionGetNumbers(){
    	$idDQ = (int) $_POST['idDQ'];
    		$numbers = array();
    	if ($idDQ!=2){
	    	$criteria = new CDbCriteria();
			$criteria->addCondition('type_execution = 1 and id_type_dq ='.$idDQ);
			$process_rows_correct = ProcessSpecimensExecutionAR::model()->findAll($criteria);
			
			$criteria = new CDbCriteria();
			$criteria->addCondition('type_execution = 2 and id_type_dq ='.$idDQ);
			$process_rows_detect = ProcessSpecimensExecutionAR::model()->findAll($criteria);
	    	
	    	
	    
	    	$numbers [] = array ('correction'=>sizeof($process_rows_correct), 'detection'=>sizeof($process_rows_detect));
    	}
    	else if ($idDQ==2){
	    	$criteria = new CDbCriteria();
			$criteria->addCondition('type_execution = 4 and id_type_dq ='.$idDQ);
			$process_rows_correct = ProcessTaxonExecutionAR::model()->findAll($criteria);
			
			$criteria = new CDbCriteria();
			$criteria->addCondition('type_execution = 2 and id_type_dq ='.$idDQ);
			$process_rows_detect = ProcessTaxonExecutionAR::model()->findAll($criteria);
	    	
	    	
	    	
	    	$numbers [] = array ('correction'=>sizeof($process_rows_correct), 'detection'=>sizeof($process_rows_detect));
	    	
    	}
		echo CJSON::encode($numbers);
    	
    }
    
			public function actionTestTaxonHierarchy() {
			
			$name =  $_POST['name'];
			$taxon = $_POST['taxon'];
			
	        $l =  new DataqualityLogic(); 
	       	$rs = $l->searchColHierarchy($name,$taxon,'col');
	        
	        echo CJSON::encode($rs);
	      
			}
			
			public function actionTestCheckTaxonHierarchy(){
    			$id_specimen = $_POST['id_specimen'];
    			$teste = $this->CheckTaxonHierarchy($id_specimen);
    			echo CJSON::encode($teste);
			}
 

function getCoordenadas($municipality,$stateprovince,$country){
 
	 $address = $municipality.'+'.$stateprovince.'+'.$country;
	
		 $URL = 'http://maps.googleapis.com/maps/api/geocode/json?';   
       	 $options = array("address"=>$address,"sensor"=>"false");
   		 $URL .= http_build_query($options,'','&');

   		 $jason_dta = file_get_contents($URL) or die(print_r(error_get_last()));
    	
   		 $output= json_decode($jason_dta,true);
		 if ($output['status']=='OK'){
			 $array_locaties = array();
	   		 foreach ($output['results'] as $res){
	   		 	 
	   		 	  $locality = '';
	   		 	  $state = '';
	   		 	  $country = '';
	   		 	  
	   		 	  $sub = 0;
	   		 	  
		   		  foreach ($res['address_components'] as $adc){
		   		 	
		   		  	 
		   		 	 if ($adc["types"][0] == "sublocality"){
		   		  		$sub = 1;
		   		  	 }
		   		  	
		   		  	if ($adc["types"][0] == "administrative_area_level_1"){
		   		  	
		   		  		$state = $adc["long_name"];
		   		  	}
		   		  	
		   		 	 if ($adc["types"][0] == "locality"){
		   		  		$locality = $adc["long_name"];
		   	
		   		  	}
		   		   if ($adc["types"][0] == "country"){
		   		  		$country = $adc["long_name"];
		   	
		   		  	}
		   		 	
		   		 	
		   		 }
		   		 $latitude = $res['geometry']['location']['lat'];
		   		 $longitude =$res['geometry']['location']['lng'];
		   		 $formatted_address= $locality.', '.$state.', '.$country;
		   		 
		   		 if (($sub == 0)){
		   		 	if($locality!=''){
			   			$array_locaties = array("locality"=>$locality,"state"=>$state, "country"=>$country,"latitude"=>$latitude,"longitude"=>$longitude,
			   									"formatted_address"=>$formatted_address);
		   		 	}
		   		 }
		   		
	   		  } //end for
	   		
	   		  return $array_locaties;
		 }
}
public function actionCidades(){
	 $l =  new DataqualityLogic(); 
	 $rs = $l->Cidades();
	 
	 if(is_array($rs)){
	 	foreach($rs as $r){
	 		
	 		$array_cord = $this->getCoordenadas($r['municipality'],$r['stateprovince'],$r['country']);
	 		if (sizeof($array_cord)){
	 			
	 			///update
	 			$rs = $l->updateCidades($r['municipality'],$array_cord['latitude'],$array_cord['longitude']);
	 			
	 			
	 		}
	 		
	 	}
	 	
	 }
	 
	 echo CJSON::encode($rs);
	 
	 
	
}
}
 
    
		
			
