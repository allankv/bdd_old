<?php

class AutocompleteController extends CController {

    public function getArrayValores($tableField,$name,$idSelect,$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus, $_formIdSubgenus, $_formIdSpecificEpithet,$_formIdInfraSpecificEpithet,$_formIdScientificName) {
//	public function getArrayValores(){		

        //limite para consultas
        $limit=15;

        //estabelece a condição de pesquisa da consulta
        if ($name<>"")
            $sqlBusca = " AND  lower(".$tableField.") LIKE lower('%$name%')";

        if ($idSelect<>"")
            $sqlBusca = " AND  id".$tableField." = ".$idSelect;

        //monta a consulta que filtra os registros de acordo com os valores do formulario

        $sqlFields = "FROM taxonomicelements WHERE 'this'='this' ";

        if($_formIdKingdom<>"")
            $sqlFields .= " AND taxonomicelements.idkingdom = ".$_formIdKingdom." ";

        if($_formIdPhylum<>"")
            $sqlFields .= " AND taxonomicelements.idphylum = ".$_formIdPhylum." ";

        if($_formIdClass<>"")
            $sqlFields .= " AND taxonomicelements.idclass = ".$_formIdClass." ";

        if($_formIdOrder<>"")
            $sqlFields .= " AND taxonomicelements.idorder = ".$_formIdOrder." ";

        if($_formIdFamily<>"")
            $sqlFields .= " AND taxonomicelements.idfamily = ".$_formIdFamily." ";

        if($_formIdGenus<>"")
            $sqlFields .= " AND taxonomicelements.idgenus = ".$_formIdGenus." ";

        if($_formIdSubgenus<>"")
            $sqlFields .= " AND taxonomicelements.idsubgenus = ".$_formIdSubgenus." ";

        if($_formIdSpecificEpithet<>"")
            $sqlFields .= " AND taxonomicelements.idspecificepithet = ".$_formIdSpecificEpithet." ";

        if($_formIdInfraSpecificEpithet<>"")
            $sqlFields .= " AND taxonomicelements.idinfraspecificepithets = ".$_formIdInfraSpecificEpithets." ";

        if($_formIdScientificName<>"")
            $sqlFields .= " AND taxonomicelements.idscientificname = ".$_formIdScientificName." ";


        //relaciona a pesquisa a um model
        switch($tableField) {

            case "scientificname" :

                $sqlComm = "SELECT DISTINCT  idscientificname, scientificname
						FROM scientificnames WHERE 'this'='this' ";

                if(($_formIdKingdom<>"")||($_formIdPhylum<>"")||($_formIdClass<>"")||($_formIdOrder<>"")||($_formIdFamily<>"")||($_formIdGenus<>"")||($_formIdSubgenus<>"")||($_formIdSpecificEpithet<>"")||($_formIdInfraEspecificEpithet<>"")||($_formIdScientificName<>""))
                    $sqlComm .=	" AND idscientificname IN (SELECT idscientificname ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = scientificnames::model()->findAllBySql($sqlComm);

                break;

            case "kingdom":

                $sqlComm = "SELECT DISTINCT  idkingdom, kingdom
						FROM kingdoms WHERE 'this'='this' ";

                if(($_formIdKingdom<>"")||($_formIdPhylum<>"")||($_formIdClass<>"")||($_formIdOrder<>"")||($_formIdFamily<>"")||($_formIdGenus<>"")||($_formIdSubgenus<>"")||($_formIdSpecificEpithet<>"")||($_formIdInfraEspecificEpithet<>"")||($_formIdScientificName<>""))
                    $sqlComm .=	" AND idKingdom IN (SELECT idKingdom ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = kingdoms::model()->findAllBySql($sqlComm);

                break;

            case "class":

                $sqlComm = "SELECT DISTINCT  idclass, \"class\"
						FROM classes WHERE 'this'='this' ";

                if(($_formIdKingdom<>"")||($_formIdPhylum<>"")||($_formIdClass<>"")||($_formIdOrder<>"")||($_formIdFamily<>"")||($_formIdGenus<>"")||($_formIdSubgenus<>"")||($_formIdSpecificEpithet<>"")||($_formIdInfraEspecificEpithet<>"")||($_formIdScientificName<>""))
                    $sqlComm .=	" AND idclass IN (SELECT \"idclass\" ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = classes::model()->findAllBySql($sqlComm);

                break;

            case "order":

                $sqlComm = "SELECT DISTINCT  idorder, \"order\"
						FROM orders WHERE 'this'='this' ";

                if(($_formIdKingdom<>"")||($_formIdPhylum<>"")||($_formIdClass<>"")||($_formIdOrder<>"")||($_formIdFamily<>"")||($_formIdGenus<>"")||($_formIdSubgenus<>"")||($_formIdSpecificEpithet<>"")||($_formIdInfraEspecificEpithet<>"")||($_formIdScientificName<>""))
                    $sqlComm .=	" AND idorder IN (SELECT idorder ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = orders::model()->findAllBySql($sqlComm);

                break;

            case "family":

                $sqlComm = "SELECT DISTINCT  idfamily, family
						FROM families WHERE 'this'='this' ";

                if(($_formIdKingdom<>"")||($_formIdPhylum<>"")||($_formIdClass<>"")||($_formIdOrder<>"")||($_formIdFamily<>"")||($_formIdGenus<>"")||($_formIdSubgenus<>"")||($_formIdSpecificEpithet<>"")||($_formIdInfraEspecificEpithet<>"")||($_formIdScientificName<>""))
                    $sqlComm .=	" AND idfamily IN (SELECT idfamily ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = families::model()->findAllBySql($sqlComm);

                break;

            case "genus":

                $sqlComm = "SELECT DISTINCT  idgenus, genus
						FROM genus WHERE 'this'='this' ";

                if(($_formIdKingdom<>"")||($_formIdPhylum<>"")||($_formIdClasse<>"")||($_formIdOrder<>"")||($_formIdFamily<>"")||($_formIdGenus<>"")||($_formIdSpecificEpithet<>"")||($_formIdInfraEspecificEpithet<>"")||($_formIdScientificName<>""))
                    $sqlComm .=	" AND idgenus IN (SELECT idgenus ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = genus::model()->findAllBySql($sqlComm);

                break;

            case "subgenus":

                $sqlComm = "SELECT DISTINCT  idsubgenus, subgenus
						FROM subgenus WHERE 'this'='this' ";

                if(($_formIdKingdom<>"")||($_formIdPhylum<>"")||($_formIdClasse<>"")||($_formIdOrder<>"")||($_formIdFamily<>"")||($_formIdGenus<>"")||($_formIdSubgenus<>"")||($_formIdSpecificEpithet<>"")||($_formIdInfraEspecificEpithet<>"")||($_formIdScientificName<>""))
                    $sqlComm .=	" AND idsubgenus IN (SELECT idsubgenus ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = subgenus::model()->findAllBySql($sqlComm);

                break;

            case "phylum":

                $sqlComm = "SELECT DISTINCT  idphylum, phylum
						FROM phylums WHERE 'this'='this' ";

                if(($_formIdKingdom<>"")||($_formIdPhylum<>"")||($_formIdClass<>"")||($_formIdOrder<>"")||($_formIdFamily<>"")||($_formIdGenus<>"")||($_formIdSubgenus<>"")||($_formIdSpecificEpithet<>"")||($_formIdInfraEspecificEpithet<>"")||($_formIdScientificName<>""))
                    $sqlComm .=	" AND idphylum IN (SELECT idphylum ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = phylums::model()->findAllBySql($sqlComm);

                break;

            case "specificepithet":

                $sqlComm = "SELECT DISTINCT  idspecificepithet, specificepithet
						FROM specificepithets WHERE 'this'='this' ";

                if(($_formIdKingdom<>"")||($_formIdPhylum<>"")||($_formIdClass<>"")||($_formIdOrder<>"")||($_formIdFamily<>"")||($_formIdGenus<>"")||($_formIdSubgenus<>"")||($_formIdSpecificEpithet<>"")||($_formIdInfraEspecificEpithet<>"")||($_formIdScientificName<>""))
                    $sqlComm .=	" AND idspecificepithet IN (SELECT idspecificepithet ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = specificepithets::model()->findAllBySql($sqlComm);

                break;

            case "infraspecificepithet":

                $sqlComm = "SELECT DISTINCT  idinfraspecificepithet, infraspecificepithet
						FROM infraspecificepithets WHERE 'this'='this' ";

                if(($_formIdKingdom<>"")||($_formIdPhylum<>"")||($_formIdClass<>"")||($_formIdOrder<>"")||($_formIdFamily<>"")||($_formIdGenus<>"")||($_formIdSubgenus<>"")||($_formIdSpecificEpithet<>"")||($_formIdInfraEspecificEpithet<>"")||($_formIdScientificName<>""))
                    $sqlComm .=	" AND idinfraspecificepithet IN (SELECT idinfraspecificepithet ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = infraspecificepithets::model()->findAllBySql($sqlComm);

                break;

            case "infraspecificrank":

                $sqlComm = "SELECT DISTINCT  idtaxonrank, infraspecificrank
						FROM taxonranks WHERE 'this'='this' ";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = taxonranks::model()->findAllBySql($sqlComm);

                break;

            case "nomenclaturalcode":

                $sqlComm = "SELECT DISTINCT idnomenclaturalcode, nomenclaturalcode
						FROM nomenclaturalcodes WHERE 'this'='this' ";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = nomenclaturalcodes::model()->findAllBySql($sqlComm);

                break;

            case "parentnameusage":

                $sqlComm = "SELECT DISTINCT idparentnameusage, parentnameusage
						FROM parentnameusage WHERE 'this'='this' ";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = parentnameusage::model()->findAllBySql($sqlComm);

                break;
            case "originalnameusage":

                $sqlComm = "SELECT DISTINCT idoriginalnameusage, originalnameusage
						FROM originalnameusage WHERE 'this'='this' ";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = originalnameusage::model()->findAllBySql($sqlComm);

                break;
            case "nameaccordingto":

                $sqlComm = "SELECT DISTINCT idnameaccordingto, nameaccordingto
						FROM nameaccordingto WHERE 'this'='this' ";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = nameaccordingto::model()->findAllBySql($sqlComm);

                break;
            case "namepublishedin":

                $sqlComm = "SELECT DISTINCT idnamepublishedin, namepublishedin
						FROM namepublishedin WHERE 'this'='this' ";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = namepublishedin::model()->findAllBySql($sqlComm);

                break;
            case "taxonconcept":

                $sqlComm = "SELECT DISTINCT idtaxonconcept, taxonconcept
						FROM taxonconcept WHERE 'this'='this' ";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = taxonconcept::model()->findAllBySql($sqlComm);

                break;
            case "acceptednameusage":

                $sqlComm = "SELECT DISTINCT idacceptednameusage, acceptednameusage
						FROM acceptednameusage WHERE 'this'='this' ";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = acceptednameusage::model()->findAllBySql($sqlComm);

                break;

            case "scientificnameauthorship":

                $sqlComm = "SELECT DISTINCT idscientificnameauthorship, scientificnameauthorship
						FROM scientificnameauthorship WHERE 'this'='this' ";

                $sqlComm .=	$sqlBusca;

                if($limit > 0) $sqlComm .= " limit $limit";

                $resultArray = scientificnameauthorship::model()->findAllBySql($sqlComm);

                break;

        }


        return $resultArray;
    }


    public function actionIndex() {

        if(((Yii::app()->request->isAjaxRequest) && isset($_GET['q'])||(isset($_GET['idSelect'])))) {

            //nome a ser procurado no banco de dados
            $name = $_GET['q'];

            //tabela em que a consulta ser� realizada
            $field = $_GET['tableField'];

            //ID do um elemento selecionado na tela de listagem de valores
            $idSelectedElement = $_GET['idSelect'];

            //valores dos campos no formulario
            $_formFilledIdKingdom = $_GET['formIdKingdom'];
            $_formFilledIdPhylum = $_GET['formIdPhylum'];
            $_formFilledIdClass = $_GET['formIdClass'];
            $_formFilledIdOrder = $_GET['formIdOrder'];
            $_formFilledIdFamily = $_GET['formIdFamily'];
            $_formFilledIdGenus = $_GET['formIdGenus'];
            $_formFilledIdSubgenus = $_GET['formIdSubgenus'];
            $_formFilledIdSpecificEpithet = $_GET['formIdEspecificEpithet'];
            $_formFilledIdInfraSpecificEpithet = $_GET['formIdInfraSpecificepithet'];
            $_formFilledIdScientificName = $_GET['formIdScientificName'];


            // this was set with the "max" attribute of the CAutoComplete widget
            //$limit = min($_GET['max'], 15);

            $returnVal = '';

            /*
			 * Coloca em um array os valores possiveis para o AutoComplete
            */
            $resultArray = $this->getArrayValores($field,$name,$idSelectedElement,$_formFilledIdKingdom,$_formFilledIdPhylum,$_formFilledIdClass,$_formFilledIdOrder,$_formFilledIdFamily,$_formFilledIdGenus,$_formFilledIdSubgenus,$_formFilledIdSpecificEpithet,$_formFilledIdInfraSpecificEpithet,$_formFilledIdScientificName);

            /*
			 * Identifica o campo em que est� sendo requisitado o AutoComplete
			 * Para os campos com nivel taxonomico maior verifica a possibilidade de preencher automaticamente um valor
            */

            /*
			 * Parametros de envio para a View na sequencia: 
			 * 
			 * nome do reino
			 * id reino selecionado
			 * 
			 * nome do filo
			 * id filo selecionado
			 * 
			 * nome da classe
			 * id classe selecionada
			 *  
			 * nome da ordem
			 * id ordem selecionada
			 * 
			 * nome da familia
			 * id familia selecionada
			 * 
			 * nome da genero
			 * id genero selecionado 
			 * 
			 * nome da especie
			 * id esp�cie selecionada
			 * 
            */

            foreach($resultArray as $scname) {

                $_formNameKingdom = "";
                $_formNamePhylum = "";
                $_formNameClass = "";
                $_formNameOrder = "";
                $_formNameFamily = "";
                $_formNameGenus = "";
                $_formNameSubgenus = "";
                $_formNameSpecificEpithet = "";
                $_formNameInfraSpecificEpithet = "";
                $_formNameScientificName = "";

                if ($_formFilledIdKingdom=="")
                    $_formIdKingdom = "";
                else
                    $_formIdKingdom = $_formFilledIdKingdom;


                if ($_formFilledIdPhylum=="")
                    $_formIdPhylum = "";
                else
                    $_formIdPhylum = $_formFilledIdPhylum;

                if ($_formFilledIdClass=="")
                    $_formIdClass = "";
                else
                    $_formIdClass = $_formFilledIdClass;

                if ($_formFilledIdOrder=="")
                    $_formIdOrder = "";
                else
                    $_formIdOrder = $_formFilledIdOrder;

                if ($_formFilledIdFamily=="")
                    $_formIdFamily = "";
                else
                    $_formIdFamily = $_formFilledIdFamily;

                if ($_formFilledIdGenus=="")
                    $_formIdGenus = "";
                else
                    $_formIdGenus = $_formFilledIdGenus;


                if ($_formFilledIdSubgenus=="")
                    $_formIdSubgenus = "";
                else
                    $_formIdSubgenus = $_formFilledIdSubgenus;


                if ($_formFilledIdSpecificEpithet=="")
                    $_formIdSpecificEpithet = "";
                else
                    $_formIdSpecificEpithet = $_formFilledIdSpecificEpithet;

                if ($_formFilledIdInfraSpecificEpithet=="")
                    $_formIdInfraSpecificEpithet = "";
                else
                    $_formIdInfraSpecificEpithet = $_formFilledIdInfraSpecificEpithet;

                if ($_formFilledIdScientificName=="")
                    $_formIdScientificName = "";
                else
                    $_formIdScientificName = $_formFilledIdScientificName;

                switch($field) {
                    case "kingdom" :
                        $_formIdKingdom = $scname->getAttribute("id".$field);
                        break;

                    case "phylum" :

                        $_formIdPhylum = $scname->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("kingdom","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameKingdom = $scRelName->getAttribute("kingdom");
                                $_formIdKingdom = $scRelName->getAttribute("idkingdom");
                            }

                        }

                        break;

                    case "class" :

                        $_formIdClass = $scname->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("kingdom","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameKingdom = $scRelName->getAttribute("kingdom");
                                $_formIdKingdom = $scRelName->getAttribute("idkingdom");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("phylum","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNamePhylum = $scRelName->getAttribute("phylum");
                                $_formIdPhylum = $scRelName->getAttribute("idphylum");
                            }
                        }

                        break;

                    case "order" :


                        $_formIdOrder = $scname->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("kingdom","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);


                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameKingdom = $scRelName->getAttribute("kingdom");
                                $_formIdKingdom = $scRelName->getAttribute("idkingdom");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("phylum","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNamePhylum = $scRelName->getAttribute("phylum");
                                $_formIdPhylum = $scRelName->getAttribute("idphylum");
                            }
                        }

                        $resultArrayAux = $this->getArrayValores("class","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameClass = $scRelName->getAttribute("class");
                                $_formIdClass = $scRelName->getAttribute("idclass");
                            }
                        }

                        break;

                    case "family" :

                        $_formIdFamily = $scname->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("kingdom","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameKingdom = $scRelName->getAttribute("kingdom");
                                $_formIdKingdom = $scRelName->getAttribute("idkingdom");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("phylum","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);


                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNamePhylum = $scRelName->getAttribute("phylum");
                                $_formIdPhylum = $scRelName->getAttribute("idphylum");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("class","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameClass = $scRelName->getAttribute("class");
                                $_formIdClass = $scRelName->getAttribute("idclass");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("order","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameOrder = $scRelName->getAttribute("order");
                                $_formIdOrder = $scRelName->getAttribute("idorder");
                            }

                        }

                        break;

                    case "genus" :

                        $_formIdGenus = $scname->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("kingdom","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameKingdom = $scRelName->getAttribute("kingdom");
                                $_formIdKingdom = $scRelName->getAttribute("idkingdom");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("phylum","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNamePhylum = $scRelName->getAttribute("phylum");
                                $_formIdPhylum = $scRelName->getAttribute("idphylum");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("class","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameClass = $scRelName->getAttribute("class");
                                $_formIdClass = $scRelName->getAttribute("idclass");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("order","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameOrder = $scRelName->getAttribute("order");
                                $_formIdOrder = $scRelName->getAttribute("idorder");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("family","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameFamily = $scRelName->getAttribute("family");
                                $_formIdFamily = $scRelName->getAttribute("idfamily");
                            }

                        }

                        break;

                    case "subgenus" :

                        $_formIdSubgenus = $scname->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("kingdom","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameKingdom = $scRelName->getAttribute("kingdom");
                                $_formIdKingdom = $scRelName->getAttribute("idkingdom");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("phylum","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNamePhylum = $scRelName->getAttribute("phylum");
                                $_formIdPhylum = $scRelName->getAttribute("idphylum");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("class","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameClass = $scRelName->getAttribute("class");
                                $_formIdClass = $scRelName->getAttribute("idclass");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("order","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameOrder = $scRelName->getAttribute("order");
                                $_formIdOrder = $scRelName->getAttribute("idorder");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("family","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameFamily = $scRelName->getAttribute("family");
                                $_formIdFamily = $scRelName->getAttribute("idfamily");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("genus","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameFamily = $scRelName->getAttribute("genus");
                                $_formIdFamily = $scRelName->getAttribute("idgenus");
                            }

                        }

                        break;

                    case "specificepithet":

                        $_formIdSpecificEpithet = $scname->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("kingdom","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameKingdom = $scRelName->getAttribute("kingdom");
                                $_formIdKingdom = $scRelName->getAttribute("idkingdom");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("phylum","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNamePhylum = $scRelName->getAttribute("phylum");
                                $_formIdPhylum = $scRelName->getAttribute("idphylum");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("class","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameClass = $scRelName->getAttribute("class");
                                $_formIdClass = $scRelName->getAttribute("idclass");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("order","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameOrder = $scRelName->getAttribute("order");
                                $_formIdOrder = $scRelName->getAttribute("idorder");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("family","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameFamily = $scRelName->getAttribute("family");
                                $_formIdFamily = $scRelName->getAttribute("idfamily");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("genus","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameGenus = $scRelName->getAttribute("genus");
                                $_formIdGenus = $scRelName->getAttribute("idgenus");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("subgenus","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameSubgenus = $scRelName->getAttribute("subgenus");
                                $_formIdSubgenus = $scRelName->getAttribute("idsubgenus");
                            }

                        }



                        break;

                    case "infraspecificepithet":

                        $_formIdInfraSpecificEpithet = $scname->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("kingdom","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameKingdom = $scRelName->getAttribute("kingdom");
                                $_formIdKingdom = $scRelName->getAttribute("idkingdom");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("phylum","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNamePhylum = $scRelName->getAttribute("phylum");
                                $_formIdPhylum = $scRelName->getAttribute("idphylum");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("class","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameClass = $scRelName->getAttribute("class");
                                $_formIdClass = $scRelName->getAttribute("idclass");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("order","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameOrder = $scRelName->getAttribute("order");
                                $_formIdOrder = $scRelName->getAttribute("idorder");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("family","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameFamily = $scRelName->getAttribute("family");
                                $_formIdFamily = $scRelName->getAttribute("idfamily");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("genus","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameGenus = $scRelName->getAttribute("genus");
                                $_formIdGenus = $scRelName->getAttribute("idgenus");
                            }

                        }
                        $resultArrayAux = $this->getArrayValores("subgenus","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameSubgenus = $scRelName->getAttribute("subgenus");
                                $_formIdsubgenus = $scRelName->getAttribute("idsubgenus");
                            }

                        }
                        $resultArrayAux = $this->getArrayValores("specificepithet","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameSpecificEpithet = $scRelName->getAttribute("specificepithet");
                                $_formIdSpecificEpithet = $scRelName->getAttribute("idspecificepithet");
                            }
                        }


                        break;

                    case "scientificname" :



                        $_formIdScientificName = $scname->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("kingdom","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameKingdom = $scRelName->getAttribute("kingdom");
                                $_formIdKingdom = $scRelName->getAttribute("idkingdom");
                            }

                        }


                        $resultArrayAux = $this->getArrayValores("phylum","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNamePhylum = $scRelName->getAttribute("phylum");
                                $_formIdPhylum = $scRelName->getAttribute("idphylum");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("class","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameClass = $scRelName->getAttribute("class");
                                $_formIdClass = $scRelName->getAttribute("idclass");
                            }

                        }


                        $resultArrayAux = $this->getArrayValores("order","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameOrder = $scRelName->getAttribute("order");
                                $_formIdOrder = $scRelName->getAttribute("idorder");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("family","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameFamily = $scRelName->getAttribute("family");
                                $_formIdFamily = $scRelName->getAttribute("idfamily");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("genus","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameGenus = $scRelName->getAttribute("genus");
                                $_formIdGenus = $scRelName->getAttribute("idgenus");
                            }

                        }
                        $resultArrayAux = $this->getArrayValores("subgenus","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithet,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameSubgenus = $scRelName->getAttribute("subgenus");
                                $_formIdSubgenus = $scRelName->getAttribute("idsubgenus");
                            }

                        }

                        
                        $resultArrayAux = $this->getArrayValores("specificepithet","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameSpecificEpithet = $scRelName->getAttribute("specificepithet");
                                $_formIdSpecificEpithet = $scRelName->getAttribute("idspecificepithet");
                            }
                        }



                        $resultArrayAux = $this->getArrayValores("infraspecificepithet","","",$_formIdKingdom,$_formIdPhylum,$_formIdClass,$_formIdOrder,$_formIdFamily,$_formIdGenus,$_formIdSubgenus,$_formIdSpecificEpithet,$_formIdInfraEspecificEpithets,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $scRelName) {
                                $_formNameInfraSpecificEpithet = $scRelName->getAttribute("infraspecificepithet");
                                $_formIdInfraSpecificEpithet = $scRelName->getAttribute("idinfraspecificepithet");
                            }
                        }

                        break;
                }
                $returnVal .= $scname->getAttribute($field).'|'.$scname->getAttribute("id".$field).'|'.$_formNameKingdom.'|'.$_formIdKingdom.'|'.$_formNamePhylum.'|'.$_formIdPhylum.'|'.$_formNameClass.'|'.$_formIdClass.'|'.$_formNameOrder.'|'.$_formIdOrder.'|'.$_formNameFamily.'|'.$_formIdFamily.'|'.$_formNameGenus.'|'.$_formIdGenus.'|'.$_formNameSubgenus.'|'.$_formIdSubgenus.'|'.$_formNameSpecificEpithet.'|'.$_formIdSpecificEpithet.'|'.$_formNameScientificName.'|'.$_formIdScientificName." \n";
            }


            echo $returnVal;

        }

        die();
    }
}
