<?php

class MapController extends CController
{
	public function actionIndex()
	{
		Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

            $recordlevelelements = recordlevelelements::model();
            $occurrenceelements = occurrenceelements::model();
            $taxonomicelements = taxonomicelements::model();              

            if($_GET['idinstitutioncode']!=""){
            	$recordlevelelements->setAttributes(array("idinstitutioncode"=>$_GET['idinstitutioncode']));
            }else{
            	
            	//mostra apenas os institution codes que contem recordlevelelements completos
            
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
				$institutioncodes = institutioncodes::model()->findAllBySql($sqlComm);
            
            }
            
	        if($_GET['idcollectioncode']!=""){
            	$recordlevelelements->setAttributes(array("idcollectioncode"=>$_GET['idcollectioncode']));
            }            

            if($_GET['catalognumber']!=""){
            	$occurrenceelements->setAttributes(array("catalognumber"=>$_GET['catalognumber']));
            }
            
            if($_GET['idscientificname']!=""){
            	$taxonomicelements->setAttributes(array("idscientificname"=>$_GET['idscientificname']));
            }	               
                
            list($arrayOfCoordinates, $arrayOfContentWindow, $recordlevelelementsListMap) = $this->setArrayOfCoordinates();

    		$this->render('index', array('recordlevelelements'=>$recordlevelelements,
                                  'occurrenceelements'=>$occurrenceelements,
    							  'institutioncodes'=>$institutioncodes,
    							  'taxonomicelements'=>$taxonomicelements,
                                  'arrayOfCoordinates'=>$arrayOfCoordinates,
                                  'arrayOfContentWindow'=>$arrayOfContentWindow,
                                  'recordlevelelementsListMap'=>$recordlevelelementsListMap,
                                ));
	}

        public function setArrayOfCoordinates(){

            //This variable renders javascript array
            $data = $this->getMapData();
            $array = "var specime = [";
            $arrayContent = "var Content = [";

            $i=0;//Set zindex

            if($data !== null) {
                foreach($data as $dt) {
                    $i++;
                    $scientificname = $dt['scientificname'];
                    $institutioncode = $dt['institutioncode'];
                    $collectioncode = $dt['collectioncode'];
                    $catalognumber = $dt['catalognumber'];
                    $lat = $dt['decimallatitude'];
                    $log = $dt['decimallongitude'];
                    $idgeo = $dt['idgeospatialelements'];
                    
                    $array .= "[$lat, $log],";

                    $windowcontent = "\"Scientificname: <b>$scientificname</b><br>Institution code: $institutioncode<br>Collection code: $collectioncode<br>Catalog number: $catalognumber<br>Lat: $lat<br>Long: $log\"";
                    //$windowcontent = "'Scientificname: <b>$scientificname</b>'";
                    $arrayContent .= "$windowcontent,";
                }
            }

            $array .= "];";
            $arrayContent .= "];";

            return array($array, $arrayContent, $data);
        }

        public function getMapData() {
      

            $idinstitutioncode = $_GET['idinstitutioncode'];
            $idcollectioncode = $_GET['idcollectioncode'];
            $catalognumber = $_GET['catalognumber'];
            $idscientificname = $_GET['idscientificname'];

            $result = null;
            
            if($idinstitutioncode <> "" || $idcollectioncode <> "" || $catalognumber <> "" || $idscientificname <> "") {          
            
                if($idscientificname != "") {
                        $taxonomicelements = taxonomicelements::model()->findByAttributes(array('idscientificname'=>$idscientificname))->getAttributes();
                        $idtaxonomicelements = $taxonomicelements['idtaxonomicelements'];
                }
                
	            $query  = "SELECT idgeospatialelements, scientificname, institutioncode, collectioncode, 
	            					catalognumber, locality, county, stateprovince, decimallatitude, decimallongitude, 
	            					thepoint_geospatialelements
	            					
	            		   FROM view_geospatialelements 
	            		   WHERE 1=1 ";                

                $query .= ($idinstitutioncode == "" ? "" : " AND idinstitutioncode = $idinstitutioncode");
                $query .= ($idcollectioncode == "" ? "" : " AND idcollectioncode = $idcollectioncode");
                $query .= ($catalognumber == "" ? "" : " AND catalognumber = '$catalognumber'");
                $query .= ($idscientificname == "" ? "" : " AND idtaxonomicelements IN
                		 ( 
							SELECT idtaxonomicelements
						    FROM taxonomicelements
						    WHERE idscientificname = ".$idscientificname."
                		 
                		 )  ");

                $result = WebbeeController::executaSQL($query);

            }

            return $result;
        }

	/*
	 * Controller method for set language session parameter
	 */
	public function actionSiteLanguage() {
		$this->render('sitelanguage');
	}

        
}