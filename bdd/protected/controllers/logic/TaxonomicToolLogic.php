<?php

/*
  include 'InstitutionCodeLogic.php';
  include 'CollectionCodeLogic.php';
  include 'ScientificNameLogic.php';
  include 'BasisOfRecordLogic.php';

  include 'KingdomLogic.php';
  include 'PhylumLogic.php';
  include 'ClassLogic.php';
  include 'OrderLogic.php';
  include 'FamilyLogic.php';
  include 'GenusLogic.php';
  include 'SubgenusLogic.php';
  include 'SpecificEpithetLogic.php';

  include 'CountryLogic.php';
  include 'StateProvinceLogic.php';
  include 'CountyLogic.php';
  include 'MunicipalityLogic.php';
  include 'LocalityLogic.php';

  include 'RecordLevelElementLogic.php';
  include 'OccurrenceElementLogic.php';
  include 'TaxonomicElementLogic.php';
  include 'CuratorialElementLogic.php';
  include 'IdentificationElementLogic.php';
  include 'EventElementLogic.php';
  include 'LocalityElementLogic.php';
  include 'GeospatialElementLogic.php';
  include_once 'MediaLogic.php';
  include_once 'ReferenceLogic.php';

  include_once 'InteractionLogic.php';
 */

class TaxonomicToolLogic {

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

    function validate($q, $r) {
        $sql = "select lsid, taxon from taxa where is_accepted_name = 1 and name = '" . trim($q) . "' offset 0 limit 1 ";
        $res = $this->execColSql($sql);
        $rs = array("valid" => false);
        if ($res) {
            while ($linha = pg_fetch_array($res)) {
                // VERIFICAR SE SAO DO MESMO RANK
                $sql = "UPDATE \"" . $r . "\" SET colvalidation = true WHERE \"" . $r . "\"='" . trim($q) . "'";
                $aux = WebbeeController::executaSQL($sql);

                $rs = array("valid" => true);
            }
        }
        return $rs;
    }

    function hierarchyValidation($h) {
        $rs = array();

        if ($h['infraspecificepithet'] != '') {
            return false; //$rs = $this->searchColHierarchy($h['infraspecificepithet'],'Infraspecific epithet','col');
        } else if ($h['infraspecies'] != '') {
            $rs = $this->searchColHierarchy($h['infraspecies'], 'Infraspecies', 'col');
            $rs['h'] = $this->searchColHierarchy($h['scientificname'], 'Species', 'col');
            foreach ($rs as $linha) {
                if ($linha[0]['name'] == $h['infraspecies'] &&
                        $linha[1]['name'] == $h['scientificname'] &&
                        $linha[2]['name'] == $h['genus'] &&
                        $linha[3]['name'] == $h['family'] &&
                        $linha[5]['name'] == $h['order'] &&
                        $linha[6]['name'] == $h['class'] &&
                        $linha[7]['name'] == $h['phylum'] &&
                        $linha[8]['name'] == $h['kingdom'] &&
                        $h['subgenus'] == '') {
                    return true;
                }
            }
            return false;
        } else if ($h['scientificname'] != '') {
            $rs['h'] = $this->searchColHierarchy($h['scientificname'], 'Species', 'col');
            foreach ($rs as $linha) {
                if ($linha[0]['name'] == $h['scientificname'] &&
                        $linha[1]['name'] == $h['genus'] &&
                        $linha[2]['name'] == $h['family'] &&
                        $linha[4]['name'] == $h['order'] &&
                        $linha[5]['name'] == $h['class'] &&
                        $linha[6]['name'] == $h['phylum'] &&
                        $linha[7]['name'] == $h['kingdom'] &&
                        $h['subgenus'] == '') {
                    return true;
                }
            }
            return false;
        } else if ($h['subgenus'] != '') {
            return false; //$rs = $this->searchColHierarchy($h['subgenus'],'Subgenus','col');
        } else if ($h['genus'] != '') {
            $rs = $this->searchColHierarchy($h['genus'], 'Genus', 'col');
            foreach ($rs as $linha) {
                if ($linha[0]['name'] == $h['genus'] &&
                        $linha[1]['name'] == $h['family'] &&
                        $linha[3]['name'] == $h['order'] &&
                        $linha[4]['name'] == $h['class'] &&
                        $linha[5]['name'] == $h['phylum'] &&
                        $linha[6]['name'] == $h['kingdom']) {
                    return true;
                }
            }
            return false;
        } else if ($h['family'] != '') {
            $rs = $this->searchColHierarchy($h['family'], 'Family', 'col');
            foreach ($rs as $linha) {
                if ($linha[0]['name'] == $h['family'] &&
                        $linha[2]['name'] == $h['order'] &&
                        $linha[3]['name'] == $h['class'] &&
                        $linha[4]['name'] == $h['phylum'] &&
                        $linha[5]['name'] == $h['kingdom']) {
                    return true;
                }
            }
            return false;
        } else if ($h['order'] != '') {
            $rs = $this->searchColHierarchy($h['order'], 'Order', 'col');
            foreach ($rs as $linha) {
                if ($linha[0]['name'] == $h['order'] &&
                        $linha[1]['name'] == $h['class'] &&
                        $linha[2]['name'] == $h['phylum'] &&
                        $linha[3]['name'] == $h['kingdom']) {
                    return true;
                }
            }
            return false;
        } else if ($h['class'] != '') {
            $rs = $this->searchColHierarchy($h['class'], 'Class', 'col');
            foreach ($rs as $linha) {
                if ($linha[0]['name'] == $h['class'] &&
                        $linha[1]['name'] == $h['phylum'] &&
                        $linha[2]['name'] == $h['kingdom']) {
                    return true;
                }
            }
            return false;
        } else if ($h['phylum'] != '') {
            $rs = $this->searchColHierarchy($h['phylum'], 'Phylum', 'col');
            foreach ($rs as $linha) {
                if ($linha[0]['name'] == $h['phylum'] &&
                        $linha[1]['name'] == $h['kingdom']) {
                    return true;
                }
            }
            return false;
        } else if ($h['kingdom'] != '') {
            $rs = $this->searchColHierarchy($h['kingdom'], 'Kingdom', 'col');
            foreach ($rs as $linha) {
                if ($linha[0]['name'] == $h['kingdom']) {
                    return true;
                }
            }
            return false;
        }

        return false;
    }

    public function getColHierarchyById($id) {
        $rs = null; // = array();
        $sql = "select record_id, name, taxon, parent_id from taxa where is_accepted_name = 1 and record_id = " . $id . " offset 0 limit 1 ";
        $cons = $this->execColSql($sql);
        while ($linha = pg_fetch_array($cons)) {
            /* if($linha['parent_id']!=0){			
              $linhap = $this->getColHierarchyById($linha['parent_id']);
              } */
            $rs = $linha; //[$linha['taxon']] = $linha;
            //$rs[$linhap['taxon']] = $linhap;
        }
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

        $sql = "select record_id, name, taxon, parent_id from taxa where is_accepted_name = 1 and taxon='" . $r . "' and name = '" . $q . "' ";
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

    public function searchLocalHierarchy($q, $r, $s) {
        $q = trim($q);
        $r = $s == 'local' ? $r : ($r == "Kingdom" ? "kingdom" :
                        ($r == "Species" ? "scientificname" :
                                ($r == "Infraspecies" ? "infraspecificepithet" :
                                        ($r == "Genus" ? "genus" :
                                                ($r == "Phylum" ? "phylum" :
                                                        ($r == "Class" ? "class" :
                                                                ($r == "Family" ? "family" :
                                                                        ($r == "Superfamily" ? "family" :
                                                                                ($r == "Order" ? "order" : "")))))))));
        $c = array();
        $rs = array();

        // get ID
        $aux = WebbeeController::executaSQL("select id$r from \"" . $r . "\" where \"" . $r . "\"='" . $q . "'");

        if ($aux != null) {
            $regId = $aux[0]["id$r"];

            $where = " AND t.id$r = $regId";

            $id = " t.id$r ";
            $field = " \"" . $r . "\".\"" . $r . "\" ";

            $id = $id . ($r == 'phylum' ? ', t.idkingdom ' : '');
            $id = $id . ($r == 'class' ? ', t.idkingdom, t.idphylum ' : '');
            $id = $id . ($r == 'order' ? ', t.idkingdom, t.idphylum, t.idclass ' : '');
            $id = $id . ($r == 'family' ? ', t.idkingdom, t.idphylum, t.idclass, t.idorder ' : '');
            $id = $id . ($r == 'genus' ? ', t.idkingdom, t.idphylum, t.idclass, t.idorder, t.idfamily ' : '');
            $id = $id . ($r == 'subgenus' ? ', t.idkingdom, t.idphylum, t.idclass, t.idorder, t.idfamily, t.idgenus ' : '');
            $id = $id . ($r == 'specificepithet' ? ', t.idkingdom, t.idphylum, t.idclass, t.idorder, t.idfamily, t.idgenus, t.idsubgenus ' : '');
            $id = $id . ($r == 'infraspecificepithet' ? ', t.idkingdom, t.idphylum, t.idclass, t.idorder, t.idfamily, t.idgenus, t.idsubgenus, t.idspecificepithet ' : '');
            $id = $id . ($r == 'scientificname' ? ', t.idkingdom, t.idphylum, t.idclass, t.idorder, t.idfamily, t.idgenus, t.idsubgenus, t.idspecificepithet, t.idinfraspecificepithet ' : '');

            $field = $field . ($r == 'phylum' ? ', kingdom ' : '');
            $field = $field . ($r == 'class' ? ', kingdom, phylum ' : '');
            $field = $field . ($r == 'order' ? ', kingdom, phylum, "class"' : '');
            $field = $field . ($r == 'family' ? ', kingdom, phylum, "class", "order" ' : '');
            $field = $field . ($r == 'genus' ? ', kingdom, phylum, "class", "order", family ' : '');
            $field = $field . ($r == 'subgenus' ? ', kingdom, phylum, "class", "order", family, genus ' : '');
            $field = $field . ($r == 'specificepithet' ? ', kingdom, phylum, "class", "order", family, genus, subgenus ' : '');
            $field = $field . ($r == 'infraspecificepithet' ? ', kingdom, phylum, "class", "order", family, genus, subgenus, specificepithet ' : '');
            $field = $field . ($r == 'scientificname' ? ', kingdom, phylum, "class", "order", family, genus, subgenus, specificepithet, infraspecificepithet ' : '');

            $c['select'] = "SELECT count(*), $id, t.colvalidation, "; //t.idscientificname, t.idkingdom, t.idphylum, t.idclass, t.idorder, t.idfamily, t.idgenus, t.idspecificepithet, t.idinfraspecificepithet, t.idsubgenus, ";
            $c['select'] = $c['select'] . " $field "; //scientificname.scientificname, kingdom.kingdom, phylum.phylum, "class"."class" as class_, "order"."order", family.family, genus.genus, specificepithet.specificepithet, infraspecificepithet.infraspecificepithet, subgenus.subgenus ';
            $c['from'] = ' FROM taxonomicelement t ';
            $c['join'] = $c['join'] . ' LEFT JOIN kingdom ON t.idkingdom = kingdom.idkingdom ';
            $c['join'] = $c['join'] . ' LEFT JOIN phylum ON t.idphylum = phylum.idphylum ';
            $c['join'] = $c['join'] . ' LEFT JOIN "class" ON t.idclass = "class".idclass ';
            $c['join'] = $c['join'] . ' LEFT JOIN "order" ON t.idorder = "order".idorder ';
            $c['join'] = $c['join'] . ' LEFT JOIN family ON t.idfamily = family.idfamily ';
            $c['join'] = $c['join'] . ' LEFT JOIN genus ON t.idgenus = genus.idgenus ';
            $c['join'] = $c['join'] . ' LEFT JOIN subgenus ON t.idsubgenus = subgenus.idsubgenus ';
            $c['join'] = $c['join'] . ' LEFT JOIN specificepithet ON t.idspecificepithet = specificepithet.idspecificepithet ';
            $c['join'] = $c['join'] . ' LEFT JOIN infraspecificepithet ON t.idinfraspecificepithet = infraspecificepithet.idinfraspecificepithet ';
            $c['join'] = $c['join'] . ' LEFT JOIN scientificname ON t.idscientificname = scientificname.idscientificname ';
            $c['where'] = ' WHERE 1 = 1 ' . $where;
            //$c['orderby'] = ' ORDER BY scientific.title ';
            //$c['limit'] = ' limit '.$filter['limit'];
            //$c['offset'] = ' offset '.$filter['offset'];
            // junta tudo
            $sql = $c['select'] . $c['from'] . $c['join'] . $c['where']; //.$c['orderby'].$c['limit'].$c['offset'];
            // faz consulta e manda para list
            //echo $sql;die();
            $rs['list'] = WebbeeController::executaSQL('select * from (' . $sql . ' group by ' . $id . ',t.colvalidation, ' . $field . ') h order by colvalidation, count DESC');
        }
        for ($i = 0; $i < count($rs['list']); $i++) {
            $rs['list'][$i]['class_'] = $rs['list'][$i]['class'];
            unset($rs['list'][$i]['class']);
        }

        return $rs;



        /* foreach ($res as $linha) {
          $rs[] = array("id" => $linha['idscientificname'],"rank" =>'scientificname',"label" => $linha['scientificname'],"desc" => ($linha['colvalidation']==true?'Valid name':'Not valid name'),"level" => 'Scientific Name',"icon" => ($linha['colvalidation']==true?"images/specimen/ITIS.gif":"images/specimen/notvalid.png"),"valid" => $linha['colvalidation']);
          } */
    }

    public function searchLocal($q, $l, $onlyValid) {
        $q = trim($q);
        $onlyValid = $onlyValid ? ' and colvalidation = true ' : '';
        $rs = array();

        if (preg_match("/([a-z]|[A-Z])[a-z]* sp(([ .]([0-9][0-9]*)?)|([0-9][0-9]*)?|(. ([0-9][0-9]*)?)|(p.?))/", $q) && !preg_match("/([a-z]|[A-Z])[a-z]* sp([a-o]|[q-z])[a-z]*/", $q)) {
            //$rs[] = array("id" => 0, "rank" => 'genus', "label" => "Funcionou", "desc" => "(36)", "level" => 'Morphospecies', "icon" => "images/specimen/ITIS.gif", "valid" => false);
            $r = split(" ", $q, 2);
            $g = $r[0];
            $g[0] = strtoupper($g[0]);
            $m = ($r[1] == 'sp' || $r[1] == 'sp.' || $r[1] == 'spp') ? 'spp.' : $r[1];

            if ($m != 'spp.') {
                $arr = str_split($m); //transforma a string $m na array $arr
                $n = count($arr); //$n = numero de elementos da array $arr
                foreach ($arr as $k => $v) {
                    if (!preg_match("/[0-9][0-9]*/", $v))
                        unset($arr[$k]);
                }
                $m = "sp." . implode("", $arr);
            }

            $gm = $g." ".$m;
            //$rs[] = array("id" => 0, "rank" => 'genus', "label" => $gm, "desc" => "(36)", "level" => 'Morphospecies', "icon" => "images/specimen/ITIS.gif", "valid" => false);

            
            $sql = "select * from genus where genus = '$g'";
            $hasGenus = WebbeeController::executaSQL($sql);
            if (empty($hasGenus))
            	$rs[] = array("id" => null, "rank" => 'New', "label" => $gm, "desc" => 'New morphospecies?', "level" => 'New', "icon" => "images/specimen/new.png", "valid" => false);
            
	        $idGroup = Yii::app()->user->getGroupId();
			
	   		if ($idGroup!=2){
	        	 $groupSQL = ' AND (s.idgroup='.$idGroup.') ';
	        }
            $sql = "select * from genus where levenshtein(UPPER(genus),UPPER('$g'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(genus),UPPER('$g')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            // percorre generos
	            foreach ($res as $linha) {
	                $sql2 = "select count(*) as n, m.idmorphospecies as id from specimen s 
	                	LEFT JOIN taxonomicelement t ON s.idtaxonomicelement = t.idtaxonomicelement LEFT JOIN morphospecies m ON
	                     t.idmorphospecies = m.idmorphospecies WHERE m.morphospecies ='" . $linha['genus'] . ' ' . $m ."'". $groupSQL."group by m.idmorphospecies";
	                // procuro relacoes com morphospecies
	                $numero = WebbeeController::executaSQL($sql2);
				
					
	                $sql3 = "select count(*) as n, idmorphospecies as id from morphospecies WHERE morphospecies ='" . $linha['genus'] . ' ' . $m . "' group by idmorphospecies";
	                $numero2 = WebbeeController::executaSQL($sql3);
	                $n3 = 0;
	                $idm = 0;
	                foreach ($numero2 as $n2) {
	                    $n3 = $n2['n'];
	                    $idm = $n2['id'];
	                }
	                //Nao houver relacao
	                if (empty($numero)) {
	                    /* $sql3 = "SELECT idmorphospecies FROM morphospecies WHERE morphospecies ='".$linha['genus'].' '.$m."'";
	                      $delusedmorphospecies = WebbeeController::executaSQL($sql3);
	                      foreach ($delusedmorphospecies as $idmorp){
	                      $sql4 = "DELETE FROM taxonomicelement WHERE idmorphospecies = ".$idmorp['idmorphospecies'].";";
	                      WebbeeController::executaSQL2($sql4);
	                      //$rs[] = array("id" => null, "rank" => 'genus', "label" => $controle, "desc" =>'Morphospecies', "level" => 'New', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
	                      $sql4 = "DELETE FROM morphospecies WHERE idmorphospecies = ".$idmorp['idmorphospecies'].";";
	                      WebbeeController::executaSQL2($sql4);
	                      //$rs[] = array("id" => null, "rank" => 'genus', "label" => $controle, "desc" =>'Morphospecies', "level" => 'New', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
	                      } */
	                    // nao ha morfoespecie
	                    if ($n3 == 0) {
	                        $rs[] = array("id" => null, "rank" => 'genus', "label" => $linha['genus'] . ' ' . $m, "desc" => 'Morphospecies', "level" => 'New', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
	                    } else {
	                        $rs[] = array("id" => $idm, "rank" => 'genus', "label" => $linha['genus'] . ' ' . $m, "desc" => 'Morphospecies', "level" => 0, "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
	                    }
	                } else {
	                    foreach ($numero as $n) {
	                        $rs[] = array("id" => $n['id'], "rank" => 'genus', "label" => $linha['genus'] . ' ' . $m, "desc" => 'Morphospecies', "level" => $n['n'], "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
	                    }
	                }
	            }            
        } else {
            if (!$onlyValid)
                $rs[] = array("id" => null, "rank" => 'New', "label" => $q, "desc" => 'New taxon name?', "level" => 'New', "icon" => "images/specimen/new.png", "valid" => false);
            $sql = "select * from scientificname where levenshtein(UPPER(scientificname),UPPER('$q'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(scientificname),UPPER('$q')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            foreach ($res as $linha) {
                $rs[] = array("id" => $linha['idscientificname'], "rank" => 'scientificname', "label" => $linha['scientificname'], "desc" => ($linha['colvalidation'] == true ? 'Valid name' : 'Not valid name'), "level" => 'Scientific Name', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
            }
            $sql = "select * from infraspecificepithet where levenshtein(UPPER(infraspecificepithet),UPPER('$q'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(infraspecificepithet),UPPER('$q')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            foreach ($res as $linha) {
                $rs[] = array("id" => $linha['idinfraspecificepithet'], "rank" => 'infraspecificepithet', "label" => $linha['infraspecificepithet'], "desc" => ($linha['colvalidation'] == true ? 'Valid name' : 'Not valid name'), "level" => 'Infraspecific epithet', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
            }
            $sql = "select * from specificepithet where levenshtein(UPPER(specificepithet),UPPER('$q'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(specificepithet),UPPER('$q')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            foreach ($res as $linha) {
                $rs[] = array("id" => $linha['idspecificepithet'], "rank" => 'specificepithet', "label" => $linha['specificepithet'], "desc" => ($linha['colvalidation'] == true ? 'Valid name' : 'Not valid name'), "level" => 'Specific epithet', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
            }
            $sql = "select * from subgenus where levenshtein(UPPER(subgenus),UPPER('$q'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(subgenus),UPPER('$q')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            foreach ($res as $linha) {
                $rs[] = array("id" => $linha['idsubgenus'], "rank" => 'subgenus', "label" => $linha['subgenus'], "desc" => ($linha['colvalidation'] == true ? 'Valid name' : 'Not valid name'), "level" => 'Subgenus', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
            }
            $sql = "select * from genus where levenshtein(UPPER(genus),UPPER('$q'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(genus),UPPER('$q')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            foreach ($res as $linha) {
                $rs[] = array("id" => $linha['idgenus'], "rank" => 'genus', "label" => $linha['genus'], "desc" => ($linha['colvalidation'] == true ? 'Valid name' : 'Not valid name'), "level" => 'Genus', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
            }
            $sql = "select * from family where levenshtein(UPPER(family),UPPER('$q'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(family),UPPER('$q')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            foreach ($res as $linha) {
                $rs[] = array("id" => $linha['idfamily'], "rank" => 'family', "label" => $linha['family'], "desc" => ($linha['colvalidation'] == true ? 'Valid name' : 'Not valid name'), "level" => 'Family', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
            }
            $sql = "select * from \"order\" where levenshtein(UPPER(\"order\"),UPPER('$q'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(\"order\"),UPPER('$q')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            foreach ($res as $linha) {
                $rs[] = array("id" => $linha['idorder'], "rank" => 'order', "label" => $linha['order'], "desc" => ($linha['colvalidation'] == true ? 'Valid name' : 'Not valid name'), "level" => 'Order', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
            }
            $sql = "select * from class where levenshtein(UPPER(class),UPPER('$q'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(class),UPPER('$q')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            foreach ($res as $linha) {
                $rs[] = array("id" => $linha['idclass'], "rank" => 'class', "label" => $linha['class'], "desc" => ($linha['colvalidation'] == true ? 'Valid name' : 'Not valid name'), "level" => 'Class', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
            }
            $sql = "select * from phylum where levenshtein(UPPER(phylum),UPPER('$q'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(phylum),UPPER('$q')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            foreach ($res as $linha) {
                $rs[] = array("id" => $linha['idphylum'], "rank" => 'phylum', "label" => $linha['phylum'], "desc" => ($linha['colvalidation'] == true ? 'Valid name' : 'Not valid name'), "level" => 'Phylum', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
            }
            $sql = "select * from kingdom where levenshtein(UPPER(kingdom),UPPER('$q'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(kingdom),UPPER('$q')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            foreach ($res as $linha) {
                $rs[] = array("id" => $linha['idkingdom'], "rank" => 'kingdom', "label" => $linha['kingdom'], "desc" => ($linha['colvalidation'] == true ? 'Valid name' : 'Not valid name'), "level" => 'Kingdom', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
            }
        }
        return $rs;
    }

    public function searchCol($q) {
        $sql = "select record_id, name, lsid, taxon from taxa where is_accepted_name = 1 and levenshtein(name,'$q')<3 order by levenshtein(name,'$q') offset 0 limit 20 ";
        $res = $this->execColSql($sql);
        $rs = array();
        while ($linha = pg_fetch_array($res)) {
            $rs[] = array("id" => $linha['record_id'], "label" => $linha['name'], "desc" => 'description: ' . $linha['lsid'], "level" => $linha['taxon'], "icon" => "images/specimen/ITIS.gif");
        }
        return $rs;
    }

    public function searchColEqual($q) {
        $sql = "select record_id, name_with_italics, lsid, taxon from taxa where is_accepted_name = 1 and name = '$q' order by similarity(name,'$q') DESC offset 0 limit 20 ";
        $res = $this->execColSql($sql);
        $rs = array();
        while ($linha = pg_fetch_array($res)) {
            $rs[] = array("id" => $linha['record_id'], "label" => $linha['name_with_italics'], "desc" => 'description: ' . $linha['lsid'], "level" => $linha['taxon'], "icon" => "images/specimen/ITIS.gif");
        }
        return $rs;
    }

    public function searchColILike($q) {
        $sql = "select record_id, name_with_italics, lsid, taxon from taxa where is_accepted_name = 1 and name ilike '$q' order by similarity(name,'$q') DESC offset 0 limit 20 ";
        $res = $this->execColSql($sql);
        $rs = array();
        while ($linha = pg_fetch_array($res)) {
            $rs[] = array("id" => $linha['record_id'], "label" => $linha['name_with_italics'], "desc" => 'description: ' . $linha['lsid'], "level" => $linha['taxon'], "icon" => "images/specimen/ITIS.gif");
        }
        return $rs;
    }

    public function getTaxonByID($id) {
        $sql = "select parent_id, name_with_italics, taxon from taxa where record_id = $id";
        $res = $this->execColSql($sql);
        while ($linha = pg_fetch_array($res)) {
            $rs = array("id" => $linha['parent_id'], "label" => $linha['name_with_italics'], "taxon" => $linha['taxon']);
        }
        return $rs;
    }

    /*
      public function filter($filter) {
      $c = array();
      $rs = array();

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
      $catalogNumberWhere = $catalogNumberWhere.' o.catalognumber ilike \'%'.$v['id'].'%\''.' OR difference(o.catalognumber, \''.$v['id'].'\') > 3';
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


      // parametros da consulta
      $c['select'] = 'SELECT r.isrestricted, sp.idspecimen, scn.scientificname, o.catalognumber, inst.institutioncode, coll.collectioncode ';
      $c['from'] = ' FROM specimen sp ';
      $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
      $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
      $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
      $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
      $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
      $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
      $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
      $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
      $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
      $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
      $c['orderby'] = ' ORDER BY scn.scientificname, o.catalognumber, sp.idspecimen ';
      $c['limit'] = ' limit '.$filter['limit'];
      $c['offset'] = ' offset '.$filter['offset'];

      // junta tudo
      $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'].$c['limit'].$c['offset'];
      $rs['sql'] = $sql;
      // faz consulta e manda para list
      $rs['list'] = WebbeeController::executaSQL($sql);
      // altera parametros de consulta para fazer o Count
      $c['select'] = 'SELECT count(*) ';
      $sql = $c['select'].$c['from'].$c['join'].$c['where'];
      // faz consulta do Count e manda para count
      $rs['count'] = WebbeeController::executaSQL($sql);
      return $rs;
      }
     */

    public function getSpecimen($ar) {
        return $this->fillDependency($ar->findByPk($ar->idspecimen));
    }

    public function fillDependency($ar) {
        if ($ar->recordlevelelement == null)
            $ar->recordlevelelement = new RecordLevelElementAR();
        if ($ar->occurrenceelement == null)
            $ar->occurrenceelement = new OccurrenceElementAR();
        if ($ar->taxonomicelement == null)
            $ar->taxonomicelement = new TaxonomicElementAR();
        if ($ar->curatorialelement == null)
            $ar->curatorialelement = new CuratorialElementAR();
        if ($ar->identificationelement == null)
            $ar->identificationelement = new IdentificationElementAR();
        if ($ar->eventelement == null)
            $ar->eventelement = new EventElementAR();
        if ($ar->geospatialelement == null)
            $ar->geospatialelement = new GeospatialElementAR();
        if ($ar->localityelement == null)
            $ar->localityelement = new LocalityElementAR();

        $l = new RecordLevelElementLogic();
        $ar->recordlevelelement = $l->fillDependency($ar->recordlevelelement);
        $l = new OccurrenceElementLogic();
        $ar->occurrenceelement = $l->fillDependency($ar->occurrenceelement);
        $l = new TaxonomicElementLogic();
        $ar->taxonomicelement = $l->fillDependency($ar->taxonomicelement);
        $l = new CuratorialElementLogic();
        $ar->curatorialelement = $l->fillDependency($ar->curatorialelement);
        $l = new IdentificationElementLogic();
        $ar->identificationelement = $l->fillDependency($ar->identificationelement);
        $l = new EventElementLogic();
        $ar->eventelement = $l->fillDependency($ar->eventelement);
        $l = new LocalityElementLogic();
        $ar->localityelement = $l->fillDependency($ar->localityelement);
        $l = new GeospatialElementLogic();
        $ar->geospatialelement = $l->fillDependency($ar->geospatialelement);

        return $ar;
    }

    public function getMedia($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT media.idmedia, media.title, file.path, file.filesystemname, cm.categorymedia, scm.subcategorymedia ';
        $c['from'] = ' FROM specimenmedia spmedia ';
        $c['join'] = $c['join'] . ' LEFT JOIN media ON spmedia.idmedia = media.idmedia ';
        $c['join'] = $c['join'] . ' LEFT JOIN file ON media.idfile = file.idfile ';
        $c['join'] = $c['join'] . ' LEFT JOIN categorymedia cm ON media.idcategorymedia = cm.idcategorymedia ';
        $c['join'] = $c['join'] . ' LEFT JOIN subcategorymedia scm ON media.idsubcategorymedia = scm.idsubcategorymedia ';
        $c['where'] = ' WHERE spmedia.idspecimen =' . $filter['idspecimen'];

        // junta tudo
        $sql = $c['select'] . $c['from'] . $c['join'] . $c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'] . $c['from'] . $c['join'] . $c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function removeMedia($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['delete'] = 'DELETE';
        $c['from'] = ' FROM specimenmedia spmedia ';
        $c['where'] = ' WHERE spmedia.idspecimen =' . $filter['idspecimen'] . ' and spmedia.idmedia =' . $filter['idmedia'];

        // junta tudo
        $sql = $c['delete'] . $c['from'] . $c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'] . $c['from'] . $c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function getReference($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT ref.idreferenceelement, ref.title, ref.isrestricted, ref.source, cr.categoryreference, scr.subcategoryreference, tr.typereference ';
        $c['from'] = ' FROM specimenreference spref ';
        $c['join'] = $c['join'] . ' LEFT JOIN referenceelement ref ON spref.idreferenceelement = ref.idreferenceelement ';
        $c['join'] = $c['join'] . ' LEFT JOIN categoryreference cr ON ref.idcategoryreference = cr.idcategoryreference ';
        $c['join'] = $c['join'] . ' LEFT JOIN subcategoryreference scr ON ref.idsubcategoryreference = scr.idsubcategoryreference ';
        $c['join'] = $c['join'] . ' LEFT JOIN typereference tr ON ref.idtypereference = tr.idtypereference ';
        $c['where'] = ' WHERE spref.idspecimen =' . $filter['idspecimen'];

        // junta tudo
        $sql = $c['select'] . $c['from'] . $c['join'] . $c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'] . $c['from'] . $c['join'] . $c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function removeReference($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['delete'] = 'DELETE';
        $c['from'] = ' FROM specimenreference spref ';
        $c['where'] = ' WHERE spref.idspecimen =' . $filter['idspecimen'] . ' and spref.idreferenceelement =' . $filter['idreference'];

        // junta tudo
        $sql = $c['delete'] . $c['from'] . $c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'] . $c['from'] . $c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function getSpecimenByGUI($gui) {
        //retorna AR com o gui especificado ou, caso nao exista, AR vazio (nao retorna NULL!)
        $sql = 'SELECT idspecimen, sp.idrecordlevelelement, idoccurrenceelement, idtaxonomicelement, idcuratorialelement, ididentificationelement, ideventelement, idgeospatialelement, idlocalityelement FROM specimen AS sp LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement WHERE UPPER(r.globaluniqueidentifier) = UPPER(\'' . $gui . '\')';
        $rs = WebbeeController::executaSQL($sql);
        /* $criteria = new CDbCriteria();
          $criteria->join = 'LEFT JOIN recordlevelelement ON t.idrecordlevelelement = recordlevelelement.idrecordlevelelement';
          $criteria->condition = 'recordlevelelement.globaluniqueidentifier = \''.$gui.'\'';
          $ar = SpecimenAR::model()->find($criteria); */
        if ($rs[0] == null) {
            $ar = null;
            /* $ar = new SpecimenAR();

              //var_dump($ar->recordlevelelement->globaluniqueidentifier.' = '.$gui.' rs[0] = ');
              //var_dump($rs[0]);
              $ar = $ar::model();
              var_dump($ar->recordlevelelement->globaluniqueidentifier.', idrecordlevel = '.$ar->idrecordlevelelement.', idspecimen = '.$ar->idspecimen.'<\n>');
              $ar = $this->fillDependency($ar); */
        } else {
            $ar = new SpecimenAR();
            $ar->idspecimen = $rs[0]['idspecimen'];
            $ar->idrecordlevelelement = $rs[0]['idrecordlevelelement'];
            $ar->idoccurrenceelement = $rs[0]['idoccurrenceelement'];
            $ar->idtaxonomicelement = $rs[0]['idtaxonomicelement'];
            $ar->ididentificationelement = $rs[0]['ididentificationelement'];
            $ar->ideventelement = $rs[0]['ideventelement'];
            $ar->idgeospatialelement = $rs[0]['idgeospatialelement'];
            $ar->idlocalityelement = $rs[0]['idlocalityelement'];
            $ar->idcuratorialelement = $rs[0]['idcuratorialelement'];
            //$ar->setAttributes($rs[0]);
            $ar = $this->getSpecimen($ar);
        }
        return $ar;
    }

    public function deleteMedia($idmedia) {
        $ar = SpecimenMediaAR::model();
        $arList = $ar->findAll(" idmedia=$idmedia ");
        foreach ($arList as $n => $ar)
            $ar->delete();
    }

    public function deleteReference($idreference) {
        $ar = SpecimenReferenceAR::model();
        $arList = $ar->findAll(" idreferenceelement=$idreference ");
        foreach ($arList as $n => $ar)
            $ar->delete();
    }

    public function getTip($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT inst.institutioncode, coll.collectioncode ';
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'] . ' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'] . ' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'] . ' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['where'] = ' WHERE sp.idspecimen = ' . $filter['idspecimen'];

        // junta tudo
        $sql = $c['select'] . $c['from'] . $c['join'] . $c['where'];
        // faz consulta e manda para list
        $rs = WebbeeController::executaSQL($sql);

        return $rs;
    }

}

?>
