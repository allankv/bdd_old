<?php 
ini_set('max_execution_time','60000000000000');
ini_set("memory_limit","1528M");
Class Update{
	protected $host = "localhost";
	
	protected $userPg = "bdd_desenv";
	protected $pswdPg = "bdd_d3s3nv";
	protected $dbnamePg = "col";
	protected $conPg = null;
	
	protected $userMy="root";  
	protected $pswdMy="desenv"; 
	protected $dbnameMy="col_aroundtheyear"; 
	protected $conMy = null;
	
	function __construct(){} 
	
	function openPg(){
		$this->conPg = @pg_connect("host=$this->host user=$this->userPg password=$this->pswdPg dbname=$this->dbnamePg ");
		pg_set_client_encoding($this->conPg, "LATIN1");
		return $this->conPg;		
	}
	function openMy(){
		$id = null;
		if(!($id = mysql_connect($this->host,$this->userMy,$this->pswdMy))) {
		   echo "N‹o foi poss’vel estabelecer uma conex‹o com o gerenciador MySQL. Favor Contactar o Administrador.";
		   exit;
		} 
		if(!($this->conMy=mysql_select_db($this->dbnameMy,$id))) { 
		   echo "N‹o foi poss’vel estabelecer uma conex‹o com o gerenciador MySQL. Favor Contactar o Administrador.";
	   	exit;
	   	}	 
	   	$this->conMy = $id;
		return $this->conMy;
	}	
	function execMy($con,$sql) {
		$res = @mysql_query($sql,$con) or die ("N‹o foi poss’vel executar a consulta"); 	    
	    return $res;
	}
	function execPg($con,$sql) { 
		$res = pg_exec($con, $sql) or die ("N‹o foi poss’vel executar a consulta");
	    return $res;
	}	
	function close(){
		@pg_close($this->con);
	}
	function insertCommonNames($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {	
			$record_id = addslashes($linha['record_id']);
			$name_code = addslashes($linha['name_code']);
			$common_name = addslashes($linha['common_name']);
			$language = addslashes($linha['language']);
			$country = addslashes($linha['country']);
			$reference_id = addslashes($linha['reference_id']==''?0:$linha['reference_id']);
			$database_id = addslashes($linha['database_id']==''?0:$linha['database_id']);
			$is_infraspecies = addslashes($linha['is_infraspecies']==''?0:$linha['is_infraspecies']);
			
			$sqlInsert = "INSERT INTO common_names (record_id,name_code,common_name,language,country,reference_id,database_id,is_infraspecies) VALUES ($record_id,'$name_code','$common_name','$language','$country',$reference_id,$database_id,$is_infraspecies);";
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}		
	}
	function insertDatabases($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {				
			$database_name_displayed = addslashes($linha['database_name_displayed']);
			$record_id = addslashes($linha['record_id']);
			$database_name = addslashes($linha['database_name']);
			$database_full_name = addslashes($linha['database_full_name']);
			$web_site = addslashes($linha['web_site']);
			$organization = addslashes($linha['organization']);
			$contact_person = addslashes($linha['contact_person']);
			$taxa = addslashes($linha['taxa']);
			$taxonomic_coverage = addslashes($linha['taxonomic_coverage']);
			$abstract = addslashes($linha['abstract']);
			$version = addslashes($linha['version']);
			$authors_editors = addslashes($linha['authors_editors']);		

			$release_date = addslashes($linha['release_date']==''?null:$linha['release_date']);		
				
			$SpeciesCount = addslashes($linha['SpeciesCount']==''?0:$linha['SpeciesCount']);
			$SpeciesEst = addslashes($linha['SpeciesEst']==''?0:$linha['SpeciesEst']);
			$accepted_species_names = addslashes($linha['accepted_species_names']==''?0:$linha['accepted_species_names']);
			$accepted_infraspecies_names = addslashes($linha['accepted_infraspecies_names']==''?0:$linha['accepted_infraspecies_names']);
			$species_synonyms = addslashes($linha['species_synonyms']==''?0:$linha['species_synonyms']);
			$infraspecies_synonyms = addslashes($linha['infraspecies_synonyms']==''?0:$linha['infraspecies_synonyms']);
			$common_names = addslashes($linha['common_names']==''?0:$linha['common_names']);
			$total_names = addslashes($linha['total_names']==''?0:$linha['total_names']);
			$is_new = addslashes($linha['is_new']==''?0:$linha['is_new']);
			
			$sqlInsert = "INSERT INTO \"databases\" (database_name_displayed,record_id,database_name,database_full_name,web_site,organization,contact_person,taxa,taxonomic_coverage,\"abstract\",\"version\",authors_editors,release_date,speciescount,speciesest,accepted_species_names,accepted_infraspecies_names,species_synonyms,infraspecies_synonyms,common_names,total_names,is_new) VALUES ('$database_name_displayed',$record_id,'$database_name','$database_full_name','$web_site','$organization','$contact_person','$taxa','$taxonomic_coverage','$abstract','$version','$authors_editors',".($release_date==null?'null':"'$release_date'").",$SpeciesCount,$SpeciesEst,$accepted_species_names,$accepted_infraspecies_names,$species_synonyms,$infraspecies_synonyms,$common_names,$total_names,$is_new);";
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}		
	}
	function insertDistribution($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {	
			$record_id = addslashes($linha['record_id']);
			$name_code = addslashes($linha['name_code']);
			$distribution = addslashes($linha['distribution']);			
			
			$sqlInsert = "INSERT INTO distribution (record_id,name_code,distribution) VALUES ($record_id,'$name_code','$distribution');";
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}		
	}
	function insertFamilies($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {	
			$record_id = addslashes($linha['record_id']);
			$kingdom = addslashes($linha['kingdom']);
			$phylum = addslashes($linha['phylum']);
			$class = addslashes($linha['class']);
			$order = addslashes($linha['order']);
			$family = addslashes($linha['family']);
			$superfamily = addslashes($linha['superfamily']);
			$family_common_name = addslashes($linha['family_common_name']);
			$database_name = addslashes($linha['database_name']);			
			$is_accepted_name = addslashes($linha['is_accepted_name']==''?0:$linha['is_accepted_name']);
			$database_id = addslashes($linha['database_id']==''?0:$linha['database_id']);
			
			$sqlInsert = "INSERT INTO families (record_id,kingdom,phylum,\"class\",\"order\",family,superfamily,family_common_name,database_name,is_accepted_name,database_id) VALUES ($record_id,'$kingdom','$phylum','$class','$order','$family','$superfamily','$family_common_name','$database_name','$is_accepted_name','$database_id');";
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}	
	}
	function insertHardCodedSpeciesTotals($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {	
			$taxon = addslashes($linha['taxon']);
			$species_count = addslashes($linha['species_count']==''?0:$linha['species_count']);
			
			$sqlInsert = "INSERT INTO hard_coded_species_totals (taxon,species_count) VALUES ('$taxon',$species_count);";
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}		
	}
	function insertHardCodedTaxonLists($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {	
			$rank = addslashes($linha['rank']);
			$accepted_names_only = addslashes($linha['accepted_names_only']==''?0:$linha['accepted_names_only']);
			$name = addslashes($linha['name']);
						
			$sqlInsert = "INSERT INTO hard_coded_taxon_lists (rank,accepted_names_only,name) VALUES ('$rank',$accepted_names_only,'$name');";
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}		
	}
	function insertReferences($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {	
			$record_id = addslashes($linha['record_id']);
			$author = addslashes($linha['author']);
			$year = addslashes($linha['year']);
			$title = addslashes($linha['title']);
			$source = addslashes($linha['source']);
			$database_id = addslashes($linha['database_id']==''?0:$linha['database_id']);
			
			$sqlInsert = "INSERT INTO \"references\" (record_id,author,\"year\",title,source,database_id) VALUES ($record_id,'$author','$year','$title','$source',$database_id);";
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}		
	}
	function insertScientificNameReferences($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {	
			$record_id = addslashes($linha['record_id']);
			$name_code = addslashes($linha['name_code']);
			$reference_type = addslashes($linha['reference_type']);
			$reference_id = addslashes($linha['reference_id']==''?0:$linha['reference_id']);
			
			$sqlInsert = "INSERT INTO scientific_name_references (record_id,name_code,reference_type,reference_id) VALUES ($record_id, '$name_code','$reference_type',$reference_id);";
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}		
	}

	function insertScientificNames($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {	
			$record_id = addslashes($linha['record_id']);
			$name_code = addslashes($linha['name_code']);
			$web_site = addslashes($linha['web_site']);
			$genus = addslashes($linha['genus']);
			$species = addslashes($linha['species']);
			$infraspecies = addslashes($linha['infraspecies']);
			$infraspecies_marker = addslashes($linha['infraspecies_marker']);
			$author = addslashes($linha['author']);
			$accepted_name_code = addslashes($linha['accepted_name_code']);
			$comment = addslashes($linha['comment']);
			$scrutiny_date = addslashes($linha['scrutiny_date']);
			
			$sp2000_status_id = addslashes($linha['sp2000_status_id']==''?0:$linha['sp2000_status_id']);
			$database_id = addslashes($linha['database_id']==''?0:$linha['database_id']);
			$specialist_id = addslashes($linha['specialist_id']==''?0:$linha['specialist_id']);
			$family_id = addslashes($linha['family_id']==''?0:$linha['family_id']);
			$is_accepted_name = addslashes($linha['is_accepted_name']==''?0:$linha['is_accepted_name']);
			
			$sqlInsert = "INSERT INTO scientific_names (record_id,name_code,web_site,genus,species,infraspecies,infraspecies_marker,author,accepted_name_code,comment,scrutiny_date,sp2000_status_id,database_id,specialist_id,family_id,is_accepted_name) VALUES ($record_id,'$name_code','$web_site','$genus','$species','$infraspecies','$infraspecies_marker','$author','$accepted_name_code','$comment','$scrutiny_date',$sp2000_status_id,$database_id,$specialist_id,$family_id,$is_accepted_name);";			
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}		
	}

	function insertSimpleSearch($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {	
			$record_id = addslashes($linha['record_id']);
			$taxa_id = addslashes($linha['taxa_id']==''?0:$linha['taxa_id']);
			$words = addslashes($linha['words']);
			
			$sqlInsert = "INSERT INTO simple_search (record_id,taxa_id,words) VALUES ($record_id,$taxa_id,'$words');";
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}		
	}

	function insertSp2000Statuses($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {	
			$record_id = addslashes($linha['record_id']);
			$sp2000_status = addslashes($linha['sp2000_status']);
			
			$sqlInsert = "INSERT INTO sp2000_statuses (record_id,sp2000_status) VALUES ($record_id,'$sp2000_status');";
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}		
	}

	function insertSpecialists($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {	
			$record_id = addslashes($linha['record_id']);
			$specialist_name = addslashes($linha['specialist_name']);
			$database_id = addslashes($linha['database_id']==''?0:$linha['database_id']);
			
			$sqlInsert = "INSERT INTO specialists (record_id,specialist_name,database_id) VALUES ($record_id,'$specialist_name',$database_id);";
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}		
	}

	function insertTaxa($rsMy){
		$this->openPg();
		while ($linha = mysql_fetch_array($rsMy)) {	
			$record_id = addslashes($linha['record_id']);
			$lsid = addslashes($linha['lsid']);
			$name = addslashes($linha['name']);
			$name_with_italics = addslashes($linha['name_with_italics']);
			$taxon = addslashes($linha['taxon']);
			$name_code = addslashes($linha['name_code']);
			$parent_id = addslashes($linha['parent_id']==''?0:$linha['parent_id']);
			$sp2000_status_id = addslashes($linha['sp2000_status_id']==''?0:$linha['sp2000_status_id']);
			$database_id = addslashes($linha['database_id']==''?0:$linha['database_id']);
			$is_accepted_name = addslashes($linha['is_accepted_name']==''?0:$linha['is_accepted_name']);
			$is_species_or_nonsynonymic_higher_taxon = addslashes($linha['is_species_or_nonsynonymic_higher_taxon']==''?0:$linha['is_species_or_nonsynonymic_higher_taxon']);
			
			$sqlInsert = "INSERT INTO taxa (record_id,lsid,name,name_with_italics,taxon,name_code,parent_id,sp2000_status_id,database_id,is_accepted_name,is_species_or_nonsynonymic_higher_taxon) VALUES ($record_id,'$lsid','$name','$name_with_italics','$taxon','$name_code',$parent_id,$sp2000_status_id,$database_id,$is_accepted_name,$is_species_or_nonsynonymic_higher_taxon);";
			$rsPg = $this->execPg($this->conPg,$sqlInsert);
		}		
	}
} 
$update = new Update();

if($_POST['table']=='common_names'){
	$sql = "select * from common_names";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertCommonNames($rsMy);
	echo json_encode('Common names: OK');
}

if($_POST['table']=='databases'){
	$sql = "select * from `databases`";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertDatabases($rsMy);
	echo json_encode('Databases: OK');
}

if($_POST['table']=='distribution'){
	$sql = "select * from distribution";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertDistribution($rsMy);
	echo json_encode('Distributions: OK');
}

if($_POST['table']=='families'){
	$sql = "select * from families";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertFamilies($rsMy);
	echo json_encode('Families: OK');
}

if($_POST['table']=='hard_coded_species_totals'){
	$sql = "select * from hard_coded_species_totals";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertHardCodedSpeciesTotals($rsMy);
	echo json_encode('Hard coded species total: OK');
}

if($_POST['table']=='hard_coded_taxon_lists'){
	$sql = "select * from hard_coded_taxon_lists";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertHardCodedTaxonLists($rsMy);
	echo json_encode('Hard coded taxon lists: OK');
}

if($_POST['table']=='references'){
	$sql = "select * from `references`";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertReferences($rsMy);
	echo json_encode('References: OK');
}

if($_POST['table']=='scientific_name_references'){
	$sql = "select * from scientific_name_references";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertScientificNameReferences($rsMy);
	echo json_encode('Scientific names references: OK');
}

if($_POST['table']=='scientific_names'){
	$sql = "select * from scientific_names limit 0,500000";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertScientificNames($rsMy);
	$sql = "select * from scientific_names limit 500001,1000000";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertScientificNames($rsMy);
	$sql = "select * from scientific_names limit 1000001,1500000";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertScientificNames($rsMy);
	$sql = "select * from scientific_names limit 1500001,2000000";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertScientificNames($rsMy);
	$sql = "select * from scientific_names limit 2000001,2500000";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertScientificNames($rsMy);
	echo json_encode('Scientific names: OK');
}

if($_POST['table']=='simple_search'){
	$sql = "select * from simple_search limit 0,2000000";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertSimpleSearch($rsMy);
	$sql = "select * from simple_search limit 2000001,4000000";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertSimpleSearch($rsMy);
	$sql = "select * from simple_search limit 4000001,6000000";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertSimpleSearch($rsMy);
	$sql = "select * from simple_search limit 6000001,8000000";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertSimpleSearch($rsMy);
	$sql = "select * from simple_search limit 8000001,9000000";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertSimpleSearch($rsMy);
	echo json_encode('Simple search: OK');
}

if($_POST['table']=='sp2000_statuses'){
	$sql = "select * from sp2000_statuses";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertSp2000Statuses($rsMy);
	echo json_encode('Sp2000 status: OK');
}

if($_POST['table']=='specialists'){
	$sql = "select * from specialists";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertSpecialists($rsMy);
	echo json_encode('Specialists: OK');
}

if($_POST['table']=='taxa'){
	$sql = "select * from taxa";
	$rsMy = $update->execMy($update->openMy(),$sql);
	$update->insertTaxa($rsMy);
	echo json_encode('Taxa: OK');
}

$update->close();
?>