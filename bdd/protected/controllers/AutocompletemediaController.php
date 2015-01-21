<?php

class AutocompletemediaController extends CController {

    public function getArrayValores($tableField,$name,$idSelect,$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince, $_formIdCounty, $_formIdMunicipality,$_formIdLocality) {
//	public function getArrayValores(){

        //estabelece a condição de pesquisa da consulta
        if ($name<>"")
            $sqlBusca = " AND  lower(".$tableField.") LIKE lower('%$name%')";

        if ($idSelect<>"")
            $sqlBusca = " AND  id".$tableField." = ".$idSelect;

        //monta a consulta que filtra os registros de acordo com os valores do formulario

        $sqlFields = "FROM localityelements WHERE 'this'='this' ";

        if($_formIdContinent<>"")
            $sqlFields .= " AND localityelements.idcontinent = ".$_formIdContinent." ";

        if($_formIdWaterbody<>"")
            $sqlFields .= " AND localityelements.idwaterbody = ".$_formIdWaterbody." ";

        if($_formIdIslandgroup<>"")
            $sqlFields .= " AND localityelements.idislandgroup = ".$_formIdIslandgroup." ";

        if($_formIdIsland<>"")
            $sqlFields .= " AND localityelements.idisland = ".$_formIdIsland." ";

        if($_formIdCountry<>"")
            $sqlFields .= " AND localityelements.idcountry = ".$_formIdCountry." ";

        if($_formIdStateprovince<>"")
            $sqlFields .= " AND localityelements.idstateprovince = ".$_formIdStateprovince." ";

        if($_formIdCounty<>"")
            $sqlFields .= " AND localityelements.idcounty = ".$_formIdCounty." ";

        if($_formIdMunicipality<>"")
            $sqlFields .= " AND localityelements.idmunicipality = ".$_formIdMunicipality." ";

        if($_formIdLocality<>"")
            $sqlFields .= " AND localityelements.idlocality = ".$_formIdLocality." ";

        //relaciona a pesquisa a um model
        switch($tableField) {

            case "continent" :

                $sqlComm = "SELECT DISTINCT  idcontinent, continent
						FROM continents WHERE 'this'='this' ";

                if(($_formIdContinent<>"")||($_formIdWaterbody<>"")||($_formIdIslandgroup<>"")||($_formIdIsland<>"")||($_formIdCountry<>"")||($_formIdStateprovince<>"")||($_formIdCounty<>"")||($_formIdMunicipality<>"")||($_formIdLocality<>""))
                    $sqlComm .=	" AND idcontinent IN (SELECT idcontinent ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                $resultArray = continents::model()->findAllBySql($sqlComm);

                break;

            case "waterbody":

                $sqlComm = "SELECT DISTINCT  idwaterbody, waterbody
						FROM waterbodies WHERE 'this'='this' ";

                if(($_formIdContinent<>"")||($_formIdWaterbody<>"")||($_formIdIslandgroup<>"")||($_formIdIsland<>"")||($_formIdCountry<>"")||($_formIdStateprovince<>"")||($_formIdCounty<>"")||($_formIdMunicipality<>"")||($_formIdLocality<>""))
                    $sqlComm .=	" AND idwaterbody IN (SELECT idwaterbody ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                $resultArray = waterbodies::model()->findAllBySql($sqlComm);

                break;

            case "islandgroup":

                $sqlComm = "SELECT DISTINCT  idislandgroup, islandgroup
						FROM islandgroups WHERE 'this'='this' ";

                if(($_formIdContinent<>"")||($_formIdWaterbody<>"")||($_formIdIslandgroup<>"")||($_formIdIsland<>"")||($_formIdCountry<>"")||($_formIdStateprovince<>"")||($_formIdCounty<>"")||($_formIdMunicipality<>"")||($_formIdLocality<>""))
                    $sqlComm .=	" AND idislandgroup IN (SELECT idislandgroup ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                $resultArray = islandgroups::model()->findAllBySql($sqlComm);

                break;

            case "island":

                $sqlComm = "SELECT DISTINCT  idisland, island
						FROM islands WHERE 'this'='this' ";

                if(($_formIdContinent<>"")||($_formIdWaterbody<>"")||($_formIdIslandgroup<>"")||($_formIdIsland<>"")||($_formIdCountry<>"")||($_formIdStateprovince<>"")||($_formIdCounty<>"")||($_formIdMunicipality<>"")||($_formIdLocality<>""))
                    $sqlComm .=	" AND idisland IN (SELECT idisland ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                $resultArray = islands::model()->findAllBySql($sqlComm);

                break;

            case "country":

                $sqlComm = "SELECT DISTINCT  idcountry, country
						FROM countries WHERE 'this'='this' ";

                if(($_formIdContinent<>"")||($_formIdWaterbody<>"")||($_formIdIslandgroup<>"")||($_formIdIsland<>"")||($_formIdCountry<>"")||($_formIdStateprovince<>"")||($_formIdCounty<>"")||($_formIdMunicipality<>"")||($_formIdLocality<>""))
                    $sqlComm .=	" AND idcountry IN (SELECT idcountry ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                $resultArray = countries::model()->findAllBySql($sqlComm);

                break;

            case "stateprovince":

                $sqlComm = "SELECT DISTINCT  idstateprovince, stateprovince
						FROM stateprovinces WHERE 'this'='this' ";

                if(($_formIdContinent<>"")||($_formIdWaterbody<>"")||($_formIdIslandgroupe<>"")||($_formIdIsland<>"")||($_formIdCountry<>"")||($_formIdStateprovince<>"")||($_formIdMunicipality<>"")||($_formIdLocality<>""))
                    $sqlComm .=	" AND idstateprovince IN (SELECT idstateprovince ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                $resultArray = stateprovinces::model()->findAllBySql($sqlComm);

                break;

            case "county":

                $sqlComm = "SELECT DISTINCT  idcounty, county
						FROM counties WHERE 'this'='this' ";

                if(($_formIdContinent<>"")||($_formIdWaterbody<>"")||($_formIdIslandgroupe<>"")||($_formIdIsland<>"")||($_formIdCountry<>"")||($_formIdStateprovince<>"")||($_formIdCounty<>"")||($_formIdMunicipality<>"")||($_formIdLocality<>""))
                    $sqlComm .=	" AND idcounty IN (SELECT idcounty ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                $resultArray = counties::model()->findAllBySql($sqlComm);

                break;

            case "municipality":

                $sqlComm = "SELECT DISTINCT  idmunicipality, municipality
						FROM municipality WHERE 'this'='this' ";

                if(($_formIdContinent<>"")||($_formIdWaterbody<>"")||($_formIdIslandgroup<>"")||($_formIdIsland<>"")||($_formIdCountry<>"")||($_formIdStateprovince<>"")||($_formIdCounty<>"")||($_formIdMunicipality<>"")||($_formIdLocality<>""))
                    $sqlComm .=	" AND idmunicipality IN (SELECT idmunicipality ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                $resultArray = municipality::model()->findAllBySql($sqlComm);

                break;

            case "locality":

                $sqlComm = "SELECT DISTINCT  idlocality, locality
						FROM localities WHERE 'this'='this' ";

                if(($_formIdContinent<>"")||($_formIdWaterbody<>"")||($_formIdIslandgroup<>"")||($_formIdIsland<>"")||($_formIdCountry<>"")||($_formIdStateprovince<>"")||($_formIdCounty<>"")||($_formIdMunicipality<>"")||($_formIdLocality<>""))
                    $sqlComm .=	" AND idlocality IN (SELECT idlocality ".$sqlFields."  )";

                $sqlComm .=	$sqlBusca;

                $resultArray = localities::model()->findAllBySql($sqlComm);

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
            $_formFilledIdContinent = $_GET['formIdContinent'];
            $_formFilledIdWaterbody = $_GET['formIdWaterbody'];
            $_formFilledIdIslandgroup = $_GET['formIdIslandgroup'];
            $_formFilledIdIsland = $_GET['formIdIsland'];
            $_formFilledIdCountry = $_GET['formIdCountry'];
            $_formFilledIdStateprovince = $_GET['formIdStateprovince'];
            $_formFilledIdCounty = $_GET['formIdCounty'];
            $_formFilledIdMunicipality = $_GET['formIdMunicipality'];
            $_formFilledIdLocality = $_GET['formIdLocality'];


            // this was set with the "max" attribute of the CAutoComplete widget
            //$limit = min($_GET['limit'], 15);s

            $returnVal = '';

            /*
			 * Coloca em um array os valores possiveis para o AutoComplete
            */
            $resultArray = $this->getArrayValores($field,$name,$idSelectedElement,$_formFilledIdContinent,$_formFilledIdWaterbody,$_formFilledIdIslandgroup,$_formFilledIdIsland,$_formFilledIdCountry,$_formFilledIdStateprovince,$_formFilledIdCounty,$_formFilledIdMunicipality,$_formFilledIdLocality);

            foreach($resultArray as $locality) {

                $_formNameContinent = "";
                $_formNameWaterbody = "";
                $_formNameIslandgroup = "";
                $_formNameIsland = "";
                $_formNameCountry = "";
                $_formNameStateprovince = "";
                $_formNameCounty = "";
                $_formNameMunicipality = "";
                $_formNameLocality = "";

                if ($_formFilledIdContinent=="")
                    $_formIdContinent = "";
                else
                    $_formIdContinent = $_formFilledIdContinent;


                if ($_formFilledIdWaterbody=="")
                    $_formIdWaterbody = "";
                else
                    $_formIdWaterbody = $_formFilledIdWaterbody;

                if ($_formFilledIdIslandgroup=="")
                    $_formIdIslandgroup = "";
                else
                    $_formIdIslandgroup = $_formFilledIdIslandgroup;

                if ($_formFilledIdIsland=="")
                    $_formIdIsland = "";
                else
                    $_formIdIsland = $_formFilledIdIsland;

                if ($_formFilledIdCountry=="")
                    $_formIdCountry = "";
                else
                    $_formIdCountry = $_formFilledIdCountry;

                if ($_formFilledIdStateprovince=="")
                    $_formIdStateprovince = "";
                else
                    $_formIdStateprovince = $_formFilledIdStateprovince;

                if ($_formFilledIdCounty=="")
                    $_formIdCounty = "";
                else
                    $_formIdCounty = $_formFilledIdCounty;

                if ($_formFilledIdMunicipality=="")
                    $_formIdMunicipality = "";
                else
                    $_formIdMunicipality = $_formFilledIdMunicipality;

                if ($_formFilledIdLocality=="")
                    $_formIdLocality = "";
                else
                    $_formIdLocality = $_formFilledIdLocality;

                switch($field) {

                    case "continent" :
                        
                        $_formIdContinent = $locality->getAttribute("id".$field);

                        break;

                    case "waterbody" :

                        $_formIdWaterbody = $locality->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("continent","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameContinent = $RelLocality->getAttribute("continent");
                                $_formIdContinent = $RelLocality->getAttribute("idcontinent");
                            }

                        }

                        break;

                    case "islandgroup" :

                        $_formIdIslandgroup = $locality->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("continent","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameContinent = $RelLocality->getAttribute("continent");
                                $_formIdContinent = $RelLocality->getAttribute("idcontinent");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("waterbody","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameWaterbody = $RelLocality->getAttribute("waterbody");
                                $_formIdWaterbody = $RelLocality->getAttribute("idwaterbody");
                            }
                        }

                        break;

                    case "island" :


                        $_formIdIsland = $locality->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("continent","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);


                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameContinent = $RelLocality->getAttribute("continent");
                                $_formIdContinent = $RelLocality->getAttribute("idcontinent");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("waterbody","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameWaterbody = $RelLocality->getAttribute("waterbody");
                                $_formIdWaterbody = $RelLocality->getAttribute("idwaterbody");
                            }
                        }

                        $resultArrayAux = $this->getArrayValores("islandgroup","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameIslandgroup = $RelLocality->getAttribute("islandgroup");
                                $_formIdIslandgroup = $RelLocality->getAttribute("idislandgroup");
                            }
                        }

                        break;

                    case "country" :

                        $_formIdCountry = $locality->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("continent","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameContinent = $RelLocality->getAttribute("continent");
                                $_formIdContinent = $RelLocality->getAttribute("idcontinent");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("waterbody","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);


                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameWaterbody = $RelLocality->getAttribute("waterbody");
                                $_formIdWaterbody = $RelLocality->getAttribute("idwaterbody");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("islandgroup","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameIslandgroup = $RelLocality->getAttribute("islandgroup");
                                $_formIdIslandgroup = $RelLocality->getAttribute("idislandgroup");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("island","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameIsland = $RelLocality->getAttribute("island");
                                $_formIdIsland = $RelLocality->getAttribute("idisland");
                            }

                        }

                        break;

                    case "stateprovince" :

                        $_formIdStateprovince = $locality->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("continent","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameContinent = $RelLocality->getAttribute("continent");
                                $_formIdContinent = $RelLocality->getAttribute("idcontinent");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("waterbody","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameWaterbody = $RelLocality->getAttribute("waterbody");
                                $_formIdWaterbody = $RelLocality->getAttribute("idwaterbody");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("islandgroup","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameIslandgroup = $RelLocality->getAttribute("islandgroup");
                                $_formIdIslandgroup = $RelLocality->getAttribute("idislandgroup");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("island","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameIsland = $RelLocality->getAttribute("island");
                                $_formIdIsland = $RelLocality->getAttribute("idisland");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("country","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameCountry = $RelLocality->getAttribute("country");
                                $_formIdCountry = $RelLocality->getAttribute("idcountry");
                            }

                        }

                        break;

                    case "county" :

                        $_formIdCounty = $locality->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("continent","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameContinent = $RelLocality->getAttribute("continent");
                                $_formIdContinent = $RelLocality->getAttribute("idcontinent");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("waterbody","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameWaterbody = $RelLocality->getAttribute("waterbody");
                                $_formIdWaterbody = $RelLocality->getAttribute("idwaterbody");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("islandgroup","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameIslandgroup = $RelLocality->getAttribute("islandgroup");
                                $_formIdIslandgroup = $RelLocality->getAttribute("idislandgroup");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("island","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameIsland = $RelLocality->getAttribute("island");
                                $_formIdIsland = $RelLocality->getAttribute("idisland");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("country","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameCountry = $RelLocality->getAttribute("country");
                                $_formIdCountry = $RelLocality->getAttribute("idcountry");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("stateprovince","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameStateprovince = $RelLocality->getAttribute("stateprovince");
                                $_formIdStateprovince = $RelLocality->getAttribute("idstateprovince");
                            }

                        }

                        break;

                    case "municipality":

                        $_formIdMunicipality = $locality->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("continent","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameContinent = $RelLocality->getAttribute("continent");
                                $_formIdContinent = $RelLocality->getAttribute("idcontinent");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("waterbody","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameWaterbody = $RelLocality->getAttribute("waterbody");
                                $_formIdWaterbody = $RelLocality->getAttribute("idwaterbody");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("islandgroup","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameIslandgroup = $RelLocality->getAttribute("islandgroup");
                                $_formIdIslandgroup = $RelLocality->getAttribute("idislandgroup");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("island","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameIsland = $RelLocality->getAttribute("island");
                                $_formIdIsland = $RelLocality->getAttribute("idisland");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("country","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameCountry = $RelLocality->getAttribute("country");
                                $_formIdCountry = $RelLocality->getAttribute("idcountry");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("stateprovince","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameStateprovince = $RelLocality->getAttribute("stateprovince");
                                $_formIdStateprovince = $RelLocality->getAttribute("idstateprovince");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("county","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality,$_formIdScientificName);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameCounty = $RelLocality->getAttribute("county");
                                $_formIdCounty = $RelLocality->getAttribute("idcounty");
                            }

                        }

                        break;

                    case "locality":

                        $_formIdLocality = $locality->getAttribute("id".$field);

                        $resultArrayAux = $this->getArrayValores("continent","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameContinent = $RelLocality->getAttribute("continent");
                                $_formIdContinent = $RelLocality->getAttribute("idcontinent");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("waterbody","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameWaterbody = $RelLocality->getAttribute("waterbody");
                                $_formIdWaterbody = $RelLocality->getAttribute("idwaterbody");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("islandgroup","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameIslandgroup = $RelLocality->getAttribute("islandgroup");
                                $_formIdIslandgroup = $RelLocality->getAttribute("idislandgroup");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("island","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameIsland = $RelLocality->getAttribute("island");
                                $_formIdIsland = $RelLocality->getAttribute("idisland");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("country","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameCountry = $RelLocality->getAttribute("country");
                                $_formIdCountry = $RelLocality->getAttribute("idcountry");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("stateprovince","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameStateprovince = $RelLocality->getAttribute("stateprovince");
                                $_formIdStateprovince = $RelLocality->getAttribute("idstateprovince");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("county","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameCounty = $RelLocality->getAttribute("county");
                                $_formIdCounty = $RelLocality->getAttribute("idcounty");
                            }

                        }

                        $resultArrayAux = $this->getArrayValores("municipality","","",$_formIdContinent,$_formIdWaterbody,$_formIdIslandgroup,$_formIdIsland,$_formIdCountry,$_formIdStateprovince,$_formIdCounty,$_formIdMunicipality,$_formIdLocality);

                        if (count($resultArrayAux)==1) {

                            foreach($resultArrayAux as $RelLocality) {
                                $_formNameMunicipality = $RelLocality->getAttribute("municipality");
                                $_formIdMunicipality = $RelLocality->getAttribute("idmunicipality");
                            }

                        }

                        break;
                }
                $returnVal .= $locality->getAttribute($field).'|'.$locality->getAttribute("id".$field).'|'.$_formNameContinent.'|'.$_formIdContinent.'|'.$_formNameWaterbody.'|'.$_formIdWaterbody.'|'.$_formNameIslandgroup.'|'.$_formIdIslandgroup.'|'.$_formNameIsland.'|'.$_formIdIsland.'|'.$_formNameCountry.'|'.$_formIdCountry.'|'.$_formNameStateprovince.'|'.$_formIdStateprovince.'|'.$_formNameCounty.'|'.$_formIdCounty.'|'.$_formNameMunicipality.'|'.$_formIdMunicipality.'|'.$_formNameLocality.'|'.$_formIdLocality." \n";
                echo $returnVal;
            }
        }

        die();
    }
}