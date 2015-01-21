<?php

class DataqualityLogic {
	
   	protected $host = "200.144.182.25";
    protected $user = "postgres";
    protected $pswd = "VVhl5Ky!";
    protected $dbname = "col";
    protected $con = null;

    function openCoLDB() {
        $this->con = @pg_connect("host=$this->host user=$this->user password=$this->pswd dbname=$this->dbname ");
        pg_set_client_encoding($this->con, "LATIN1");
        return $this->con;
    }

    function execColSql($sql) {
        $res = pg_exec($this->openCoLDB(), $sql) or die("N‹o foi poss’vel executar a consulta");
        @pg_close($this->con);
        return $res;
    }
  
   
    
 	public function searchColSugestion($q,$taxon) {
        $sql = "select record_id, name, lsid, taxon from taxa where (is_accepted_name = 1) and (UPPER(taxon) = UPPER('$taxon')) and levenshtein(UPPER(name),UPPER('".pg_escape_string($q)."'))<5 order by levenshtein(UPPER(name),UPPER('".pg_escape_string($q)."')) offset 0 limit 3 ";
        $res = $this->execColSql($sql);
        $rs = array();
        while ($linha = pg_fetch_array($res)) {
            $rs[] = array("id" => $linha['record_id'], "label" => $linha['name'], "desc" => 'description: ' . $linha['lsid'], "level" => $linha['taxon'], "icon" => "images/specimen/ITIS.gif");
        }
        return $rs;
    }
    
	public function searchColEqual($q,$taxon) {
        $sql = "select count(record_id) as count from taxa where (is_accepted_name = 1) and (UPPER(taxon) = UPPER('$taxon')) and (UPPER(name)= UPPER('".pg_escape_string($q)."')) ";
        $res = $this->execColSql($sql);
        $rs = array();
        while ($linha = pg_fetch_array($res)) {
            $rs[] = array("count" => $linha['count']);
        }
        return $rs;
    }
    
	public function filter($idDQ,$filter) {
        $c = array();
        $rs = array();
			$criteria = '1 = 1 ';
			if (($idDQ==1)){
				 //$criteria = $criteria.' AND  (sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.'))';
				 $criteria =  $criteria.' AND ((COALESCE(geos.decimallongitude, 0) = 0) OR (COALESCE(geos.decimallatitude, 0)=0))';
        	}
        	else if (($idDQ==5)){
				// $criteria = $criteria.' AND  (sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.'))';
				 $criteria =  $criteria.' AND (((COALESCE(geos.decimallongitude, 0) !=  0) AND (COALESCE(geos.decimallatitude, 0) != 0)) AND (muni.idmunicipality is null))';
        	}
			else if (($idDQ==8)){
				 //$criteria = $criteria.' AND  (sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.'))';
				 $criteria =  $criteria.' AND ((char_length(geos.geodeticdatum) = 0) or (geos.geodeticdatum is null))';
        	}
			else if (($idDQ==7)){
				// $criteria = $criteria.' AND  (sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.'))';
				 $criteria =  $criteria.' AND (((COALESCE(geos.decimallongitude, 0) !=  0) AND (COALESCE(geos.decimallatitude, 0) != 0)) AND (geos.coordinateuncertaintyinmeters is null))';
        	}
			else if (($idDQ==4)){
				// $criteria = $criteria.' AND  (sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.'))';
				 $criteria =  $criteria.'  AND (((COALESCE(geos.decimallongitude, 0) !=  0) AND (COALESCE(geos.decimallatitude, 0) != 0)) AND (loce.idmunicipality is not null))';
				/*if ($filter['arrayOut']!=null){
					$ids = join(',',$filter['arrayOut']); 
					 $criteria = $criteria. ' AND (sp.idspecimen in ('.$ids.'))';
				}*/
        	}
	       else if (($idDQ==6)){
							 //$criteria = $criteria.' AND  (sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.'))';
							 $criteria =  $criteria.'AND ((t.idscientificname is null)
							 	OR ((t.idscientificname is not null) and (t.idgenus is null)) 
								OR ((t.idscientificname is not null) and (t.idfamily is null)) 
								OR ((t.idscientificname is not null) and (t.idorder is null))
								OR ((t.idscientificname is not null) and (t.idclass is null))
								OR ((t.idscientificname is not null) and (t.idphylum is null))
								OR ((t.idscientificname is not null) and (t.idkingdom is null)))';
			        	}
			else if (($idDQ==3)){
				 
				//$criteria = $criteria.' AND  ((sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.'))';
				//$criteria =  $criteria.' OR  (sc.idscientificname is null))';
				/*if ($filter['arrayOut']!=null){
					$ids = join(',',$filter['arrayOut']); 
					 $criteria = $criteria. ' AND ((sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.')) OR (sp.idspecimen in ('.$ids.')))';
				}*/
							
        	}
			
        	$criteria = $criteria. ' AND (	sp.idspecimen NOT IN (select id_specimen from process_specimens_execution where id_type_dq = '.$idDQ.') 
			OR (sp.idspecimen IN (select id_specimen from log_dq
				where (date_update+time_update) > 
				(select (date_finish+time_finish) as ptime from process_log_dq where id in (select max(id) from process_log_dq where date_finish is not null )) and id_type_log = '.$idDQ.')
			)
		     )';
			
        	//$criteria = 'sp.idspecimen=106';
        	
	        $c['select'] = 'SELECT sc.idscientificname,sc.scientificname,geos.coordinateuncertaintyinmeters as coordinateuncertaintyinmeters, geos.geodeticdatum as geodeticdatum ,r.isrestricted, sp.idspecimen, o.catalognumber, inst.institutioncode, 
	        coll.collectioncode, k.kingdom, p.phylum, cla.class, ord.order, fam.family, geos.decimallongitude as longitude, geos.decimallatitude as latitude, 
	        gen.genus, sub.subgenus, spec.specificepithet, ispec.infraspecificepithet, scn.scientificname,
	        cont.idcountry, cont.country as country, st.stateprovince as stateprovince , sp.idtaxonomicelement as idtaxonomicelement,
	        muni.municipality as municipality, cont.idcountry as idcountry , st.idstateprovince as idstateprovince , muni.idmunicipality as idmunicipality,
	        gen.genus,t.idgenus, t.idorder,t.idclass,t.idphylum,t.idkingdom';
	        $c['from'] = ' FROM specimen sp ';
	        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
	        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
	        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
	        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
	        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
	        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
			$c['join'] = $c['join'].' LEFT JOIN kingdom k ON t.idkingdom = k.idkingdom ';
		    $c['join'] = $c['join'].' LEFT JOIN phylum p ON t.idphylum = p.idphylum ';
		    $c['join'] = $c['join'].' LEFT JOIN class cla ON t.idclass = cla.idclass ';
		    $c['join'] = $c['join'].' LEFT JOIN "order" ord ON t.idorder = ord.idorder ';
		    $c['join'] = $c['join'].' LEFT JOIN family fam ON t.idfamily = fam.idfamily ';
		    $c['join'] = $c['join'].' LEFT JOIN genus gen ON t.idgenus = gen.idgenus ';
		    $c['join'] = $c['join'].' LEFT JOIN subgenus sub ON t.idsubgenus = sub.idsubgenus ';
		    $c['join'] = $c['join'].' LEFT JOIN specificepithet spec ON t.idspecificepithet = spec.idspecificepithet ';
		    $c['join'] = $c['join'].' LEFT JOIN infraspecificepithet ispec ON t.idinfraspecificepithet = ispec.idinfraspecificepithet ';
		    $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname ';
		    $c['join'] = $c['join'].' LEFT JOIN geospatialelement geos ON sp.idgeospatialelement = geos.idgeospatialelement ';
		    $c['join'] = $c['join'].' LEFT JOIN localityelement loce ON sp.idlocalityelement = loce.idlocalityelement ';
		    $c['join'] = $c['join'].' LEFT JOIN country cont ON loce.idcountry = cont.idcountry ';
		    $c['join'] = $c['join'].' LEFT JOIN stateprovince st ON loce.idstateprovince = st.idstateprovince ';
		    $c['join'] = $c['join'].' LEFT JOIN municipality muni ON loce.idmunicipality = muni.idmunicipality ';
		    $c['join'] = $c['join'].' LEFT JOIN scientificname sc ON t.idscientificname = sc.idscientificname ';
		    
		    
		    $criteria = $criteria.' OR (r.modified > (select max(date_finish+time_finish) from process_log_dq where date_finish is not null ))';
		   	     
		    $c['where'] = ' WHERE '.$criteria;
	        
		    //$c['option'] = ' and sp.idspecimen in (104,107, 44, 7, 57,40,66,68,69,65) ';
	        $c['orderby'] = ' ORDER BY scn.scientificname, o.catalognumber, sp.idspecimen ';
	        
	        if ($filter['limit']!=null){
	       		 $c['limit'] = ' limit '.$filter['limit'];
	        	$c['offset'] = ' offset '.$filter['offset'];
	        }
	        
	        $idGroup = Yii::app()->user->getGroupId();
			if ($idGroup!=2){
        	 $groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
       		 }
        
			//$groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
			$c['where'] =  $c['where'].$groupSQL;

	
	        // junta tudo
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['option'].$c['orderby'].$c['limit'].$c['offset'];
	        //$rs['sql'] = $sql;
	
	        if ($filter['arrayOut']!=null){
	        	//print $sql;
	        	
	        }
	        
	        if ($idDQ==7){
	        	
	        	  //print $sql;
	              exit;
	        }
	        
	     
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
 
public function filterTaxonsProcess($taxonType) {
        $c = array();
        $rs = array();
				$criteria = '1 = 1';


  
			 	$c['select'] = 'SELECT id_taxon as id, type_execution,sugestion,name_taxon as name, id_taxon_type, type_execution, sugestion';
		        $c['from'] = ' FROM public.process_taxons_execution ';

		        
		         
			    $c['where'] = ' WHERE type_execution<>0 and type_execution<>4 and id_taxon_type ='.$taxonType;
		        
		        $c['orderby'] = ' ORDER BY 4 ';
		     
		        // junta tudo
		        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'];
		
		       // print $sql;
		       // exit;
		        // faz consulta e manda para list
		        $rs['list'] = WebbeeController::executaSQL($sql);
		        
		        // altera parametros de consulta para fazer o Count
		        $c['select'] = 'SELECT count(*) ';
		        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
		        // faz consulta do Count e manda para count
		        $rs['count'] = WebbeeController::executaSQL($sql);
			
	        
        
        
        return $rs;
 }
 
public function filterTaxons($taxonType) {
        $c = array();
        $rs = array();
			$criteria = '1 = 1';

			if ($taxonType == 1){
		        $c['select'] = 'SELECT idkingdom as id, kingdom as name';
		        $c['from'] = ' FROM public.kingdom k ';
		        $criteria = $criteria.' and idkingdom not in (SELECT id_taxon FROM process_taxons_execution where id_taxon_type= '.$taxonType.')';
			}
			else if ($taxonType == 2){
		        $c['select'] = 'SELECT idphylum as id, phylum as name';
		        $c['from'] = ' FROM public.phylum p ';
		        $criteria = $criteria.' and idphylum not in (SELECT id_taxon FROM process_taxons_execution where id_taxon_type= '.$taxonType.')';
		        
			}
			else if ($taxonType == 3){
		        $c['select'] = 'SELECT idclass as id, c.class as name';
		        $c['from'] = ' FROM public.class c ';
		        $criteria = $criteria.' and idclass not in (SELECT id_taxon FROM process_taxons_execution where id_taxon_type= '.$taxonType.')';
			}
			else if ($taxonType == 4){
		        $c['select'] = 'SELECT idorder as id, o.order as name';
		        $c['from'] = ' FROM public.order o ';
		        $criteria = $criteria.' and idorder not in (SELECT id_taxon FROM process_taxons_execution where id_taxon_type= '.$taxonType.')';
			}
			else if ($taxonType == 5){
					        $c['select'] = 'SELECT idfamily as id, family as name';
					        $c['from'] = ' FROM public.family f ';
					        $criteria = $criteria.' and idfamily not in (SELECT id_taxon FROM process_taxons_execution where id_taxon_type= '.$taxonType.')';
			}
			else if ($taxonType == 6){
					        $c['select'] = 'SELECT idgenus as id, genus as name';
					        $c['from'] = ' FROM public.genus f ';
					        $criteria = $criteria.' and idgenus not in (SELECT id_taxon FROM process_taxons_execution where id_taxon_type= '.$taxonType.')';
			}
			else if ($taxonType == 7){
						        $c['select'] = 'SELECT idscientificname as id, scientificname as name';
						        $c['from'] = ' FROM public.scientificname g ';
						        $criteria = $criteria.' and idscientificname not in (SELECT id_taxon FROM process_taxons_execution where id_taxon_type= '.$taxonType.')';
			}
			
				
			    		   	     
			    $c['where'] = ' WHERE '.$criteria;
		        
		        $c['orderby'] = ' ORDER BY 2 ';
		     
		        // junta tudo
		        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'];
		
		       			
		        // faz consulta e manda para list
		        $rs['list'] = WebbeeController::executaSQL($sql);
		        
		        // altera parametros de consulta para fazer o Count
		        $c['select'] = 'SELECT count(*) ';
		        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
		        // faz consulta do Count e manda para count
		        $rs['count'] = WebbeeController::executaSQL($sql);
			
	        
        
        
        return $rs;
 }
    
public function listSpecimenToCorrection($idDQ) {
        $c = array();
        $rs = array();
		
	        if (($idDQ==1)){ ///Sem coordenadas, mas com cidade, estado e país
				$criteria = "AND (((COALESCE(geos.decimallongitude, 0) = 0) OR (COALESCE(geos.decimallatitude, 0)=0)) AND ((muni.municipality != '') ))";
	
	        }
        	else if (($idDQ==5)){
				 $criteria = $criteria.' AND  (sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.'))';
				 $criteria =  $criteria.'OR (((COALESCE(geos.decimallongitude, 0) !=  0) AND (COALESCE(geos.decimallatitude, 0) != 0)) AND (muni.idmunicipality is null))';
        	}
			else if (($idDQ==8)){
				 $criteria = $criteria.' AND  (sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.'))';
				 $criteria =  $criteria.'OR (char_length(geos.geodeticdatum) = 0)';
        	}
			else if (($idDQ==7)){
				 $criteria = $criteria.' AND  (sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.'))';
				 $criteria =  $criteria.'OR (((COALESCE(geos.decimallongitude, 0) !=  0) AND (COALESCE(geos.decimallatitude, 0) != 0)) AND (geos.coordinateuncertaintyinmeters is null))';
			        	}
        	
			else if (($idDQ==4)){
				 $criteria = $criteria.' AND  (sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.'))';
				 $criteria =  $criteria.'OR (((COALESCE(geos.decimallongitude, 0) !=  0) AND (COALESCE(geos.decimallatitude, 0) != 0)) AND (loce.idmunicipality is not null))';
        	}
			else if (($idDQ==6)){
							 $criteria = $criteria.' AND  (sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.'))';
							 $criteria =  $criteria.'OR ((t.idscientificname is null)
							 	OR ((t.idscientificname is not null) and (t.idgenus is null)) 
								OR ((t.idscientificname is not null) and (t.idfamily is null)) 
								OR ((t.idscientificname is not null) and (t.idorder is null))
								OR ((t.idscientificname is not null) and (t.idclass is null))
								OR ((t.idscientificname is not null) and (t.idphylum is null))
								OR ((t.idscientificname is not null) and (t.idkingdom is null)))';
			        	}
		   else if (($idDQ==3)){
		   	
		   		if ($filter['arrayOut']!=null){
					$ids = join(',',$filter['arrayOut']); 
					 $criteria = $criteria. ' AND ((sp.idspecimen in (select id_specimen from log_dq where id_type_log='.$idDQ.')) OR (sp.idspecimen in ('.$ids.')))';
				}
			
        	}
			        	
	        $c['select'] = 'SELECT sc.idscientificname,sc.scientificname,geos.coordinateuncertaintyinmeters as coordinateuncertaintyinmeters, geos.geodeticdatum as geodeticdatum,r.isrestricted, sp.idspecimen, o.catalognumber, inst.institutioncode, 
	        coll.collectioncode, k.kingdom, p.phylum, cla.class, ord.order, fam.family, geos.decimallongitude as longitude, geos.decimallatitude as latitude, 
	        gen.genus, sub.subgenus, spec.specificepithet, ispec.infraspecificepithet, scn.scientificname,
	        cont.idcountry, cont.country as country, st.stateprovince as stateprovince , sp.idtaxonomicelement as idtaxonomicelement,
	        muni.municipality as municipality, cont.idcountry as idcountry , st.idstateprovince as idstateprovince , muni.idmunicipality as idmunicipality,
	        gen.genus,t.idgenus, t.idorder,t.idclass,t.idphylum,t.idkingdom';
	        $c['from'] = ' FROM specimen sp ';
	        
	        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
	        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
	        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
	        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
	        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
	        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
			$c['join'] = $c['join'].' LEFT JOIN kingdom k ON t.idkingdom = k.idkingdom ';
		    $c['join'] = $c['join'].' LEFT JOIN phylum p ON t.idphylum = p.idphylum ';
		    $c['join'] = $c['join'].' LEFT JOIN class cla ON t.idclass = cla.idclass ';
		    $c['join'] = $c['join'].' LEFT JOIN "order" ord ON t.idorder = ord.idorder ';
		    $c['join'] = $c['join'].' LEFT JOIN family fam ON t.idfamily = fam.idfamily ';
		    $c['join'] = $c['join'].' LEFT JOIN genus gen ON t.idgenus = gen.idgenus ';
		    $c['join'] = $c['join'].' LEFT JOIN subgenus sub ON t.idsubgenus = sub.idsubgenus ';
		    $c['join'] = $c['join'].' LEFT JOIN specificepithet spec ON t.idspecificepithet = spec.idspecificepithet ';
		    $c['join'] = $c['join'].' LEFT JOIN infraspecificepithet ispec ON t.idinfraspecificepithet = ispec.idinfraspecificepithet ';
		    $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname ';
		    $c['join'] = $c['join'].' LEFT JOIN geospatialelement geos ON sp.idgeospatialelement = geos.idgeospatialelement ';
		    $c['join'] = $c['join'].' LEFT JOIN localityelement loce ON sp.idlocalityelement = loce.idlocalityelement ';
		    $c['join'] = $c['join'].' LEFT JOIN country cont ON loce.idcounty = cont.idcountry ';
		    $c['join'] = $c['join'].' LEFT JOIN stateprovince st ON loce.idstateprovince = st.idstateprovince ';
		    $c['join'] = $c['join'].' LEFT JOIN municipality muni ON loce.idmunicipality = muni.idmunicipality ';
		    $c['join'] = $c['join'].' LEFT JOIN scientificname sc ON t.idscientificname = sc.idscientificname ';
		    
		   	     
		    $c['where'] = ' WHERE 1=1'.$criteria;
	       // $c['option'] = ' and sp.idspecimen in (104,107, 44, 7, 57,40,66,68,69,65) ';
	    
	        // junta tudo
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['option'];
	        //$rs['sql'] = $sql;
	
	        $idGroup = Yii::app()->user->getGroupId();
			if ($idGroup!=2){
        	 $groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
       		 }
       		 
			//$groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
			$c['where'] =  $c['where'].$groupSQL;

	        // faz consulta e manda para list
	        $rs['list'] = WebbeeController::executaSQL($sql);
	        // altera parametros de consulta para fazer o Count
	        $c['select'] = 'SELECT count(*) ';
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
	        $rs['script'] = $sql;
	        // faz consulta do Count e manda para count
	        
	        $rs['count'] = WebbeeController::executaSQL($sql);
	        
        
        
        return $rs;
    }
    
	public function searchTaxonValue($taxon_name,$taxon_value) {
		$rs = array();
        $sql = "select parent_id, name_with_italics, taxon from taxa where lower(taxon) = lower('$taxon_name') and lower(name) = lower('$taxon_value')";
        $rs['list']= $this->execColSql($sql);
        print_r($rs);
        while ($linha = pg_fetch_array($rs)) {
            $rs['list'][] = array("id" => $linha['parent_id'], "value" => $linha['name_with_italics'], "name" => $linha['taxon']);
         }
        return $rs;
    }
    
	public function listSpecimenToCorrectionTaxon($filter, $id_taxon, $taxonType) {
        $c = array();
        $rs = array();
		
			switch ($taxonType){
		
					case 1 :  	$criteria = " AND t.idkingdom = '".$id_taxon."'";
					break;
					case 2 :  	$criteria = " AND t.idphylum = '".$id_taxon."'";
					break;
					case 3 :  	$criteria = " AND t.idclass = '".$id_taxon."'";
					break;
					case 4 :  	$criteria = " AND t.idorder = '".$id_taxon."'";
					break;
					case 5 :  	$criteria = " AND t.idfamily = '".$id_taxon."'";
					break;
					case 6 :  	$criteria = " AND t.idgenus = '".$id_taxon."'";
					break;
				          	 
				}
	        
	       
	          
			//
	        // parametros da consulta
	        $c['select'] = 'SELECT scn.scientificname, r.isrestricted, sp.idspecimen, o.catalognumber, inst.institutioncode, 
	        coll.collectioncode, k.kingdom, p.phylum, cla.class, ord.order, fam.family, geos.decimallongitude as longitude, geos.decimallatitude as latitude, 
	        gen.genus, sub.subgenus, spec.specificepithet, ispec.infraspecificepithet, 
	        cont.idcountry, cont.country as country, st.stateprovince as stateprovince , muni.municipality as municipality, geos.idgeospatialelement as idgeospatialelement  ';
	        $c['from'] = ' FROM specimen sp ';
	        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
	        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
	        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
	        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
	        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
	        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
			$c['join'] = $c['join'].' LEFT JOIN kingdom k ON t.idkingdom = k.idkingdom ';
		    $c['join'] = $c['join'].' LEFT JOIN phylum p ON t.idphylum = p.idphylum ';
		    $c['join'] = $c['join'].' LEFT JOIN class cla ON t.idclass = cla.idclass ';
		    $c['join'] = $c['join'].' LEFT JOIN "order" ord ON t.idorder = ord.idorder ';
		    $c['join'] = $c['join'].' LEFT JOIN family fam ON t.idfamily = fam.idfamily ';
		    $c['join'] = $c['join'].' LEFT JOIN genus gen ON t.idgenus = gen.idgenus ';
		    $c['join'] = $c['join'].' LEFT JOIN subgenus sub ON t.idsubgenus = sub.idsubgenus ';
		    $c['join'] = $c['join'].' LEFT JOIN specificepithet spec ON t.idspecificepithet = spec.idspecificepithet ';
		    $c['join'] = $c['join'].' LEFT JOIN infraspecificepithet ispec ON t.idinfraspecificepithet = ispec.idinfraspecificepithet ';
		    $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname ';
		    $c['join'] = $c['join'].' LEFT JOIN geospatialelement geos ON sp.idgeospatialelement = geos.idgeospatialelement ';
		    $c['join'] = $c['join'].' LEFT JOIN localityelement loce ON sp.idlocalityelement = loce.idlocalityelement ';
		    $c['join'] = $c['join'].' LEFT JOIN country cont ON loce.idcounty = cont.idcountry ';
		    $c['join'] = $c['join'].' LEFT JOIN stateprovince st ON loce.idstateprovince = st.idstateprovince ';
		    $c['join'] = $c['join'].' LEFT JOIN municipality muni ON loce.idmunicipality = muni.idmunicipality ';
		    
		   	     
		    $c['where'] = ' WHERE 1=1'.$criteria;
	        
	    	$c['orderby'] = ' ORDER BY 1 ';
	    	
	    	if ($filter!=null){
		    	$c['limit'] = ' limit '.$filter['limit'];
		        $c['offset'] = ' offset '.$filter['offset'];
		        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'].$c['limit'].$c['offset'];
	    	}	
	    	else {
	    		
	    		$sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'];
	    	}
	    	 
	    	$idGroup = Yii::app()->user->getGroupId();
	    	
			if ($idGroup!=2){
        	 	$groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
       		 }
       		 
			//$groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
			$c['where'] =  $c['where'].$groupSQL;
			
	        // junta tudo
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'].$c['limit'].$c['offset'];
	        //$rs['sql'] = $sql;
	
	        // faz consulta e manda para list
	        $rs['list'] = WebbeeController::executaSQL($sql);
	        // altera parametros de consulta para fazer o Count
	        $c['select'] = 'SELECT count(*) ';
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
	        // faz consulta do Count e manda para count
	        $rs['count'] = WebbeeController::executaSQL($sql);
	       
	        
        
        
        return $rs;
    }
    

 	public function searchColHierarchy($q, $r, $s) {
        $q = trim($q);
        $r = $s == 'col' ? $r : ($r == "kingdom" ? "Kingdom" :
                        ($r == "scientificname" ? "Species" :
                                ($r == "infraspecificepithet" ? "Infraspecies" :
                                        ($r == "genus" ? "Genus" :
                                                ($r == "phylum" ? "Phylum" :
                                                        ($r == "class" ? "Class" :
                                                                ($r == "family" ? "Family" :
                                                                        ($r == "order" ? "Order" : ""))))))));

        $sql = "select record_id, name, taxon, parent_id from taxa where is_accepted_name = 1 and taxon='" . pg_escape_string($r). "' and name = '" . pg_escape_string($q) . "' ";
        $res = $this->execColSql($sql);
        $rs = array();
        $h = array();
        while ($linha = pg_fetch_array($res)) {
            $rs[] = $linha;
            $p = $linha['parent_id'];
            for ($i = 0; $p > 0; $i++) {
                $aux = $this->getColHierarchyById($p);
                $rs[] = $aux;
                $p = $aux['parent_id'];
                
            }
            $h[] = $rs;
            $rs = array();
        }

        return $h;
    }
    
 	public function getColHierarchyById($id) {
        $rs = null; 
        $sql = "select record_id, name, taxon, parent_id from taxa where is_accepted_name = 1 and record_id = " . $id . " offset 0 limit 1 ";
        $cons = $this->execColSql($sql);
        while ($linha = pg_fetch_array($cons)) {
            $rs = $linha;
        }
        return $rs;
    }
    
public function filterProcess($idDQ,$filter) {
	
		
	 //Taxa filter
        $kingdomWhere = '';
        $phylumWhere ='';
        $classWhere = '';
        $orderWhere = '';
        $familyWhere = '';
        $genusWhere = '';
        $subgenusWhere = '';
        $specificEpithetWhere = '';

        //Locality filter
        $countryWhere = '';
        $stateProvinceWhere = '';
        $countyWhere = '';
        $municipalityWhere = '';
        $localityWhere = '';


        //Main fields filter
        $basisOfRecordWhere = '';
        $catalogNumberWhere = '';
        $scientificNameWhere = '';
        $institutionCodeWhere = '';
        $collectionCodeWhere = '';
		//print_r($filter['list']);
		
        if($filter['list']!=null) {
            foreach ($filter['list'] as &$v) {

                //Taxa
                if($v['controller']=='kingdom') {
                    $kingdomWhere = $kingdomWhere==''?'':$kingdomWhere.' OR ';
                    $kingdomWhere = $kingdomWhere.' t.idkingdom = '.$v['id'];
                }
                if($v['controller']=='phylum') {
                    $phylumWhere = $phylumWhere==''?'':$phylumWhere.' OR ';
                    $phylumWhere = $phylumWhere.' t.idphylum = '.$v['id'];
                }
                if($v['controller']=='class') {
                    $classWhere = $classWhere==''?'':$classWhere.' OR ';
                    $classWhere = $classWhere.' t.idclass = '.$v['id'];
                }
                if($v['controller']=='order') {
                    $orderWhere = $orderWhere==''?'':$orderWhere.' OR ';
                    $orderWhere = $orderWhere.' t.idorder = '.$v['id'];
                }
                if($v['controller']=='family') {
                    $familyWhere = $familyWhere==''?'':$familyWhere.' OR ';
                    $familyWhere = $familyWhere.' t.idfamily = '.$v['id'];
                }
                if($v['controller']=='genus') {
                    $genusWhere = $genusWhere==''?'':$genusWhere.' OR ';
                    $genusWhere = $genusWhere.' t.idgenus = '.$v['id'];
                }
                if($v['controller']=='subgenus') {
                    $subgenusWhere = $subgenusWhere==''?'':$subgenusWhere.' OR ';
                    $subgenusWhere = $subgenusWhere.' t.idsubgenus = '.$v['id'];
                }
                if($v['controller']=='specificepithet') {
                    $specificEpithetWhere = $specificEpithetWhere==''?'':$specificEpithetWhere.' OR ';
                    $specificEpithetWhere = $specificEpithetWhere.' t.idspecificepithet = '.$v['id'];
                }

                //Locality
                if($v['controller']=='country') {
                    $countryWhere = $countryWhere==''?'':$countryWhere.' OR ';
                    $countryWhere = $countryWhere.' l.idcountry = '.$v['id'];
                }
                if($v['controller']=='stateprovince') {
                    $stateProvinceWhere = $stateProvinceWhere==''?'':$stateProvinceWhere.' OR ';
                    $stateProvinceWhere = $stateProvinceWhere.' l.idstateprovince = '.$v['id'];
                }
                if($v['controller']=='county') {
                    $countyWhere = $countyWhere==''?'':$countyWhere.' OR ';
                    $countyWhere = $countyWhere.' l.idcounty = '.$v['id'];
                }
                if($v['controller']=='municipality') {
                    $municipalityWhere = $municipalityWhere==''?'':$municipalityWhere.' OR ';
                    $municipalityWhere = $municipalityWhere.' l.idmunicipality = '.$v['id'];
                }
                if($v['controller']=='locality') {
                    $localityWhere = $localityWhere==''?'':$localityWhere.' OR ';
                    $localityWhere = $localityWhere.' l.idlocality = '.$v['id'];
                }



                //Main fields
                if($v['controller']=='basisofrecord') {
                    $basisOfRecordWhere = $basisOfRecordWhere==''?'':$basisOfRecordWhere.' OR ';
                    $basisOfRecordWhere = $basisOfRecordWhere.' r.idbasisofrecord = '.$v['id'];
                }
                if($v['controller']=='catalognumber') {
                    $catalogNumberWhere = $catalogNumberWhere==''?'':$catalogNumberWhere.' OR ';
                    $catalogNumberWhere = $catalogNumberWhere.' o.catalognumber = \''.$v['id'].'\' ';
                }
                if($v['controller']=='scientificname') {
                    $scientificNameWhere = $scientificNameWhere==''?'':$scientificNameWhere.' OR ';
                    $scientificNameWhere = $scientificNameWhere.' scn.idscientificname = '.$v['id'];
                }
                if($v['controller']=='institutioncode') {
                    $institutionCodeWhere = $institutionCodeWhere==''?'':$institutionCodeWhere.' OR ';
                    $institutionCodeWhere = $institutionCodeWhere.' r.idinstitutioncode = '.$v['id'];
                }
                if($v['controller']=='collectioncode') {
                    $collectionCodeWhere = $collectionCodeWhere==''?'':$collectionCodeWhere.' OR ';
                    $collectionCodeWhere = $collectionCodeWhere.' r.idcollectioncode = '.$v['id'];
                }
            }
        }
        // se o where de cada entidades nao estiver vazias, coloca AND antes

        //Main fields
        $institutionCodeWhere = $institutionCodeWhere!=''?' AND ('.$institutionCodeWhere.') ':'';
        $collectionCodeWhere = $collectionCodeWhere!=''?' AND ('.$collectionCodeWhere.') ':'';
        $scientificNameWhere = $scientificNameWhere!=''?' AND ('.$scientificNameWhere.') ':'';
        $basisOfRecordWhere = $basisOfRecordWhere!=''?' AND ('.$basisOfRecordWhere.') ':'';
        $catalogNumberWhere = $catalogNumberWhere!=''?' AND ('.$catalogNumberWhere.') ':'';

        //Locality
        $countryWhere = $countryWhere!=''?' AND ('.$countryWhere.') ':'';
        $stateProvinceWhere = $stateProvinceWhere!=''?' AND ('.$stateProvinceWhere.') ':'';
        $countyWhere = $countyWhere!=''?' AND ('.$countyWhere.') ':'';
        $municipalityWhere = $municipalityWhere!=''?' AND ('.$municipalityWhere.') ':'';
        $localityWhere = $localityWhere!=''?' AND ('.$localityWhere.') ':'';

        //Taxa
        $kingdomWhere = $kingdomWhere!=''?' AND ('.$kingdomWhere.') ':'';
        $phylumWhere = $phylumWhere!=''?' AND ('.$phylumWhere.') ':'';
        $classWhere = $classWhere!=''?' AND ('.$classWhere.') ':'';
        $orderWhere = $orderWhere!=''?' AND ('.$orderWhere.') ':'';
        $familyWhere = $familyWhere!=''?' AND ('.$familyWhere.') ':'';
        $genusWhere = $genusWhere!=''?' AND ('.$genusWhere.') ':'';
        $subgenusWhere = $subgenusWhere!=''?' AND ('.$subgenusWhere.') ':'';
        $specificEpithetWhere = $specificEpithetWhere!=''?' AND ('.$specificEpithetWhere.') ':'';
	
        
            $c = array();
            $rs = array();
			//$criteria = '1 = 1 AND psl.date_finish is not NULL and psl.id = (select max(id) from process_log_dq) and pse.id_type_dq='.$idDQ;
						
			$criteria = '1 = 1 AND pse.id in (select max(id) from process_specimens_execution pse2 where pse2.id_specimen = pse.id_specimen and (pse2.id_type_dq = '.$idDQ.'))';
			
	        $c['select'] = 'SELECT sc.idscientificname,sc.scientificname,geos.coordinateuncertaintyinmeters as coordinateuncertaintyinmeters, geos.geodeticdatum as geodeticdatum ,r.isrestricted, sp.idspecimen, o.catalognumber, inst.institutioncode, 
	        coll.collectioncode, k.kingdom, p.phylum, cla.class, ord.order, fam.family, geos.decimallongitude as longitude, geos.decimallatitude as latitude, 
	        gen.genus, sub.subgenus, spec.specificepithet, ispec.infraspecificepithet, scn.scientificname,
	        cont.idcountry, cont.country as country, st.stateprovince as stateprovince , sp.idtaxonomicelement as idtaxonomicelement,
	        muni.municipality as municipality, cont.idcountry as idcountry , st.idstateprovince as idstateprovince , muni.idmunicipality as idmunicipality,
	        gen.genus,t.idgenus, t.idorder,t.idclass,t.idphylum,t.idkingdom, pse.sugestion as sugestion, pse.type_execution as type_execution, psl.date_finish,ldq.id_log_dq_deleted_items,ldq.undo_log as undo_log ';
	        
	        $c['from'] = 'FROM process_specimens_execution pse ';
	         
	        
	        $c['join'] = $c['join'].'LEFT JOIN process_log_dq psl ON  psl.id = pse.id_process ';
	        $c['join'] = $c['join'].'LEFT JOIN specimen sp ON sp.idspecimen = pse.id_specimen ';
	        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
	        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
	        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
	        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
	        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
	        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
			$c['join'] = $c['join'].' LEFT JOIN kingdom k ON t.idkingdom = k.idkingdom ';
		    $c['join'] = $c['join'].' LEFT JOIN phylum p ON t.idphylum = p.idphylum ';
		    $c['join'] = $c['join'].' LEFT JOIN class cla ON t.idclass = cla.idclass ';
		    $c['join'] = $c['join'].' LEFT JOIN "order" ord ON t.idorder = ord.idorder ';
		    $c['join'] = $c['join'].' LEFT JOIN family fam ON t.idfamily = fam.idfamily ';
		    $c['join'] = $c['join'].' LEFT JOIN genus gen ON t.idgenus = gen.idgenus ';
		    $c['join'] = $c['join'].' LEFT JOIN subgenus sub ON t.idsubgenus = sub.idsubgenus ';
		    $c['join'] = $c['join'].' LEFT JOIN specificepithet spec ON t.idspecificepithet = spec.idspecificepithet ';
		    $c['join'] = $c['join'].' LEFT JOIN infraspecificepithet ispec ON t.idinfraspecificepithet = ispec.idinfraspecificepithet ';
		    $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname ';
		    $c['join'] = $c['join'].' LEFT JOIN geospatialelement geos ON sp.idgeospatialelement = geos.idgeospatialelement ';
		    $c['join'] = $c['join'].' LEFT JOIN localityelement loce ON sp.idlocalityelement = loce.idlocalityelement ';
		    $c['join'] = $c['join'].' LEFT JOIN country cont ON loce.idcountry = cont.idcountry ';
		    $c['join'] = $c['join'].' LEFT JOIN stateprovince st ON loce.idstateprovince = st.idstateprovince ';
		    $c['join'] = $c['join'].' LEFT JOIN municipality muni ON loce.idmunicipality = muni.idmunicipality ';
		    $c['join'] = $c['join'].' LEFT JOIN scientificname sc ON t.idscientificname = sc.idscientificname ';
		    $c['join'] = $c['join'].' LEFT JOIN log_dq ldq on pse.id_specimen = ldq.id_specimen and
									 pse.id_type_dq = ldq.id_type_log  and ldq.undo_log is null';
		    
		    
	       $criteria = $criteria.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
		    
           $criteria = $criteria.' and pse.type_execution <> 0  and pse.id_type_dq = '.$idDQ;
		    $c['where'] = ' WHERE '.$criteria;
		    
		    $idGroup = Yii::app()->user->getGroupId();
			//$groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
			
			if ($idGroup!=2){
        	 $groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
       		 }
       		 
			$c['where'] =  $c['where'].$groupSQL;
		    
		    
	        
		    //$c['option'] = ' and sp.idspecimen in (104,107, 44, 7, 57,40,66,68,69,65) ';
	        $c['orderby'] = ' ORDER BY scn.scientificname, o.catalognumber, sp.idspecimen ';
	        
	        if ($filter['limit']!=null){
	       		 $c['limit'] = ' limit '.$filter['limit'];
	        	$c['offset'] = ' offset '.$filter['offset'];
	        }
	
	        // junta tudo
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['option'].$c['orderby'].$c['limit'].$c['offset'];
	        //$rs['sql'] = $sql;
	
	        if ($filter['arrayOut']!=null){
	        	//print $sql;
	        	
	        }
	       
	       // if ($idDQ==3){
		     //   print $sql;
		        //exit;
	        //}
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
    
public function cidades(){
	
	$sql = "SELECT distinct(muni.municipality),st.stateprovince as stateprovince,cont.country as country 
	        FROM specimen sp  LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement  
	        LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode  
	        LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement  
	        LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement  LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement   
	        LEFT JOIN geospatialelement geos ON sp.idgeospatialelement = geos.idgeospatialelement  LEFT JOIN localityelement loce ON sp.idlocalityelement = loce.idlocalityelement  LEFT JOIN country cont ON loce.idcountry = cont.idcountry  
	        LEFT JOIN stateprovince st ON loce.idstateprovince = st.idstateprovince  LEFT JOIN municipality muni ON loce.idmunicipality = muni.idmunicipality  LEFT JOIN scientificname sc ON t.idscientificname = sc.idscientificname  
	        WHERE 
	        ((COALESCE(geos.decimallongitude, 0) = 0) OR (COALESCE(geos.decimallatitude, 0)=0))
	        and  muni.municipality!=''
	        order by muni.municipality";
	
	
	 $rs = WebbeeController::executaSQL($sql);
	 return $rs;
	
}
    
function updateCidades($nome,$latitude,$longitude){
	$sql = "update geospatialelement set decimallatitude='$latitude', decimallongitude='$longitude' 
where idgeospatialelement in (

	SELECT geos.idgeospatialelement
	        FROM specimen sp  LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement  
	        --LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode  
	        LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode  
	        LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement  
	        LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement  LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement   
	        LEFT JOIN geospatialelement geos ON sp.idgeospatialelement = geos.idgeospatialelement  LEFT JOIN localityelement loce ON sp.idlocalityelement = loce.idlocalityelement  LEFT JOIN country cont ON loce.idcountry = cont.idcountry  
	        LEFT JOIN stateprovince st ON loce.idstateprovince = st.idstateprovince  LEFT JOIN municipality muni ON loce.idmunicipality = muni.idmunicipality  LEFT JOIN scientificname sc ON t.idscientificname = sc.idscientificname  
	        WHERE 
	        muni.municipality ='$nome'
)";
	
	 $rs = WebbeeController::executaSQL($sql);
	 return $rs;
} 
}



?>
