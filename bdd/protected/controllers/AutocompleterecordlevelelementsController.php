<?php

class AutocompleterecordlevelelementsController extends CController
{
	public function actionIndex() {
		$this->renderPartial('index');		
	}

	public function AutoComplete() {
                
		if(Yii::app()->request->isAjaxRequest && isset($_GET['q']))
                {
                        /* q is the default GET variable name that is used by
			* the autocomplete widget to pass in user input
			*/

                        $value = $_GET['q'];
                        $field = $_GET['tableField'];
                        $table = $_GET['table'];
	  		
	  		// this was set with the "max" attribute of the CAutoComplete widget
			$limit = min($_GET['limit'], 15);

			$query = "SELECT id$field, $field  FROM $table WHERE lower($field) LIKE lower('%$value%') ORDER BY $field LIMIT $limit";
                        
			$DataArray = WebbeeController::executaSQL($query);
			
			$returnVal = '';
			foreach($DataArray as $data)
			{
				$returnVal .= $data[$field].'|'.(($data["id".$field]=="")?"":$data["id".$field])." \n";
			}
			
			echo $returnVal;
		}
		die();
	}
}