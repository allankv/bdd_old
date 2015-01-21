<?php

class FieldsdependencyController extends CController
{
	
	
	
	public function actionIndex()
	{				
		
		if(((Yii::app()->request->isAjaxRequest) && isset($_GET['q'])))
	   {
	   	
	   		$returnVal = "";	
						

			echo $returnVal;
		
		}	
		
		die();
	}

	public function actionGetInstitutionCodes()
	{
        $sqlComm = "SELECT distinct idinstitutioncode, institutioncode 
        			FROM institutioncodes
        			WHERE idinstitutioncode IN (
        			
        				SELECT idinstitutioncode
        				FROM recordlevelelements R, collectioncodes C, taxonomicelements T, occurrenceelements O, scientificnames S
        				WHERE R.idcollectioncode = C.idcollectioncode
        					AND R.idtaxonomicelements = T.idtaxonomicelements
        					AND T.idscientificname = S.idscientificname
        					AND R.idoccurrenceelements = O.idoccurrenceelements
        			)

        			ORDER BY institutioncode
        			";
		$institutioncodesList = institutioncodes::model()->findAllBySql($sqlComm);
		
		$strResult = "";
		
		foreach($institutioncodesList as $institutioncode){
			
			$strResult .= $institutioncode->getAttribute("idinstitutioncode")."|".$institutioncode->getAttribute("institutioncode")."|";						
		
		}
		
		echo $strResult;
		
	}	
	
	
	public function actionGetCollectionCodes()
	{
	
		$idInstitutionCode = $_GET["idinstitutioncode"];
		$procuraInteracao = $_GET["procurainteracao"];
		
		$sqlComm = "SELECT distinct idcollectioncode, collectioncode 
					FROM collectioncodes
					WHERE idcollectioncode IN (
						
						SELECT R.idcollectioncode
						FROM recordlevelelements R, interactionelements I
						WHERE 1=1 ";
		
		
		if($idInstitutionCode<>"")		
			$sqlComm .= " AND R.idinstitutioncode = ".$idInstitutionCode." ";
					
//		if($procuraInteracao<>"")
//			$sqlComm .= " AND ( R.idrecordlevelelements = I.idspecimens1
//								 OR R.idrecordlevelelements = I.idspecimens2 )	";			
							 
		$sqlComm .= "	)
					
					ORDER BY collectioncode
					";		
		$collectioncodesList = collectioncodes::model()->findAllBySql($sqlComm);
		
		$strResult = "";
		
		foreach($collectioncodesList as $collectioncode){
			
			$strResult .= $collectioncode->getAttribute("idcollectioncode")."|".$collectioncode->getAttribute("collectioncode")."|";						
		
		}
		
		echo $strResult;
		
	}

	
	public function actionGetScientificNames()
	{
	
		$idInstitutionCode = $_GET["idinstitutioncode"];
		$idCollectionCode = $_GET["idcollectioncode"];
		$procuraInteracao = $_GET["procurainteracao"];
		
		$sqlComm = "SELECT distinct idscientificname, scientificname 
					FROM scientificnames
					WHERE idscientificname IN (
						
						SELECT T.idscientificname
						FROM recordlevelelements R, interactionelements I, taxonomicelements T
						WHERE	T.idtaxonomicelements = R.idtaxonomicelements";
		
		if($idInstitutionCode<>"")							 	
	 		$sqlComm .= " AND R.idinstitutioncode = ".$idInstitutionCode." ";							 	
							 	
	 	if($idCollectionCode<>"")							 	
	 		$sqlComm .= " AND R.idcollectioncode = ".$idCollectionCode." ";

//		if($procuraInteracao<>"")				 	
//			$sqlComm .= " AND ( R.idrecordlevelelements = I.idspecimens1
//								 	OR R.idrecordlevelelements = I.idspecimens2 ) "; 
						
		$sqlComm .= ")
					
					ORDER BY scientificname
					";	

		
		$scientificNamesList = scientificnames::model()->findAllBySql($sqlComm);
		
		$strResult = "";
		
		foreach($scientificNamesList as $scientificname){
			
			$strResult .= $scientificname->getAttribute("idscientificname")."|".$scientificname->getAttribute("scientificname")."|";						
		
		}
		
		echo $strResult;
		
	}	
	
	
	public function actionGetBasisOfRecords()
	{
	
		$idInstitutionCode = $_GET["idinstitutioncode"];
		$idCollectionCode = $_GET["idcollectioncode"];
		$idScientificName = $_GET["idscientificname"];
		$procuraInteracao = $_GET["procurainteracao"];
		
		$sqlComm = "SELECT distinct B.idbasisofrecord, B.basisofrecord 
					FROM basisofrecords B, recordlevelelements R, interactionelements I
					WHERE B.idbasisofrecord = R.idbasisofrecord ";
		
		if($idInstitutionCode<>"")							 	
	 		$sqlComm .= " AND R.idinstitutioncode = ".$idInstitutionCode." ";							 	
							 	
	 	if($idCollectionCode<>"")							 	
	 		$sqlComm .= " AND R.idcollectioncode = ".$idCollectionCode." ";

	 	if($idScientificName<>""){	 								 	
	 		$sqlComm .= " AND R.idtaxonomicelements IN ( 
							
	 						SELECT idtaxonomicelements
	 						FROM taxonomicelements
	 						WHERE idscientificname = ".$idScientificName."  
	 		
	 						) ";	

	 	}

//	 	if($procuraInteracao<>"")	
//			$sqlComm .= " AND ( R.idrecordlevelelements = I.idspecimens1
//								 	OR R.idrecordlevelelements = I.idspecimens2 ) "; 
						
		$sqlComm .= " 
							
					ORDER BY B.basisofrecord
					";	


		$basisOfRecordsList = basisofrecords::model()->findAllBySql($sqlComm);
		
		$strResult = "";
		
		foreach($basisOfRecordsList as $basisofrecord){
			
			$strResult .= $basisofrecord->getAttribute("idbasisofrecord")."|".$basisofrecord->getAttribute("basisofrecord")."|";						
		
		}
		
		echo $strResult;
		
	}
	
	public function actionGetCatalogNumbers()
	{
	
		$idInstitutionCode = $_GET["idinstitutioncode"];
		$idCollectionCode = $_GET["idcollectioncode"];
		$idScientificName = $_GET["idscientificname"];
		
		$sqlComm = "SELECT distinct catalognumber 
					FROM occurrenceelements
					WHERE idoccurrenceelements IN (
						
						SELECT R.idoccurrenceelements
						FROM recordlevelelements R, taxonomicelements T 
						WHERE 1 = 1";
		
		if($idInstitutionCode<>"")							 	
	 		$sqlComm .= " AND R.idinstitutioncode = ".$idInstitutionCode." ";							 	
							 	
	 	if($idCollectionCode<>"")							 	
	 		$sqlComm .= " AND R.idcollectioncode = ".$idCollectionCode." ";

	 	if($idScientificName<>""){	 								 	
	 	
	 		$sqlComm .= " AND R.idtaxonomicelements = T.idtaxonomicelements
	 				 	  AND T.idscientificname = ".$idScientificName." ";	 		
	 	}
							 	
		$sqlComm .= "
					)
					ORDER BY catalognumber
					";	

		//echo $sqlComm; 
		
		$occurrenceelementsList = occurrenceelements::model()->findAllBySql($sqlComm);
		
		$strResult = "";
		
		foreach($occurrenceelementsList as $occurrenceelement){
			
			$strResult .= $occurrenceelement->getAttribute("catalognumber")."|".$occurrenceelement->getAttribute("catalognumber")."|";						
		
		}
		
		echo $strResult;
		
	}	

	
	public function actionGetInteractionTypes()
	{
	
		$idInstitutionCode = $_GET["idinstitutioncode"];
		$idCollectionCode = $_GET["idcollectioncode"];
		$idScientificName = $_GET["idscientificname"];
		$idBasisOfRecord = $_GET["idbasisofrecord"];
		
		$sqlComm = "SELECT distinct idinteractiontype, interactiontype 
					FROM interactiontypes
					WHERE idinteractiontype IN (
						
						
						SELECT I.idinteractiontype
						FROM recordlevelelements R, interactionelements I, taxonomicelements T 
						WHERE ( I.idspecimens1 = R.idrecordlevelelements
							OR I.idspecimens2 = R.idrecordlevelelements ) ";
		
		if($idInstitutionCode<>"")							 	
	 		$sqlComm .= " AND R.idinstitutioncode = ".$idInstitutionCode." ";							 	
							 	
	 	if($idCollectionCode<>"")							 	
	 		$sqlComm .= " AND R.idcollectioncode = ".$idCollectionCode." ";

	 	if($idBasisOfRecord<>"")							 	
	 		$sqlComm .= " AND R.idbasisofrecord = ".$idBasisOfRecord." ";	 		
	 		
	 	if($idScientificName<>""){	 								 	
	 	
	 		$sqlComm .= " AND R.idtaxonomicelements = T.idtaxonomicelements
	 				 	  AND T.idscientificname = ".$idScientificName." ";	 		
	 	}
							 	
		$sqlComm .= " AND ( R.idrecordlevelelements = I.idspecimens1
							 	OR R.idrecordlevelelements = I.idspecimens2 ) 
						
					)
					
					ORDER BY interactiontype
					";	
	
		
		$interactionTypesList = interactiontypes::model()->findAllBySql($sqlComm);
		
		$strResult = "";
		
		foreach($interactionTypesList as $interactiontype){
			
			$strResult .= $interactiontype->getAttribute("idinteractiontype")."|".$interactiontype->getAttribute("interactiontype")."|";						
		
		}
		
		echo $strResult;
		
	}	
	
	/*
	 * 
	 * Utilizado no media
	 * 
	 */
	
	public function actionGetSubTypes(){
	
		$idTypeMedia = $_GET["idtypemedia"];
		
        //Criterias for filter
        $criteria=new CDbCriteria;
        $criteria->condition = " idtypemedia = ".$idTypeMedia." ";
		
		$subTypesList = subtype::model()->findAll($criteria);
		
		$strResult = "";
		
		foreach($subTypesList as $subtype){
			
			$strResult .= $subtype->getAttribute("idsubtype")."|".$subtype->getAttribute("subtype")."|";						
		
		}
		
		echo $strResult;		
	
	}

	/*
	 * 
	 * Utilizado no referenceselements
	 * 
	 */	
	
	public function actionGetSubTypeReferences(){
	
		$idTypeReferences = $_GET["idtypereferences"];
		
        //Criterias for filter
        $criteria=new CDbCriteria;
        $criteria->condition = " idtypereferences = ".$idTypeReferences." ";
		
		$subTypeReferencesList = subtypereferences::model()->findAll($criteria);
		
		$strResult = "";
		
		foreach($subTypeReferencesList as $subtypereference){
			
			$strResult .= $subtypereference->getAttribute("idsubtypereferences")."|".$subtypereference->getAttribute("subtypereferences")."|";						
		
		}
		
		echo $strResult;		
	
	}	
	
	public function actionGetRecordLevelElements()
	{
	
		$idInstitutionCode = $_GET["idinstitutioncode"];
		$idCollectionCode = $_GET["idcollectioncode"];
		$idScientificName = $_GET["idscientificname"];
		$idBasisOfRecord = $_GET["idbasisofrecord"];		

		$objSpecimen = $_GET["objSpecimen"];
		
        //Criterias for filter
        $criteria=new CDbCriteria;
        
        //$criteria->select = " idcollectioncode, idinstitutioncode, idbasisofrecord, scientificnames.scientificname  ";

        $criteria->condition = "1=1";
        $criteria->condition .= ($_GET['idcollectioncode'] == "" ? "" : " AND idcollectioncode = ".$_GET['idcollectioncode']);
        $criteria->condition .= ($_GET['idinstitutioncode'] == "" ? "" : " AND idinstitutioncode = ".$_GET['idinstitutioncode']);
        $criteria->condition .= ($_GET['idbasisofrecord'] == "" ? "" : " AND idbasisofrecord = ".$_GET['idbasisofrecord']."");
        $criteria->condition .= ($_GET['idscientificname'] == "" ? "" : " AND scientificnames.idscientificname = ".$_GET['idscientificname']);

        $criteria->join = "LEFT JOIN taxonomicelements ON taxonomicelements.idtaxonomicelements = recordlevelelements.idtaxonomicelements
                           LEFT JOIN scientificnames ON scientificnames.idscientificname = taxonomicelements.idscientificname
                           LEFT JOIN curatorialelements ON curatorialelements.idcuratorialelements = recordlevelelements.idcuratorialelements ";
        
        $criteria->order = "scientificname";

       	
        
        $recordlevelelementsList=recordlevelelements::model()->findAll($criteria);
        $interactionelements=interactionelements::model();
        
		$this->renderPartial('/interactionelements/specimens',
			array('recordlevelelementsList'=>$recordlevelelementsList,
				'interactionelements'=>$interactionelements,
				'objSpecimen'=>$objSpecimen));
	
	
	}


	
}