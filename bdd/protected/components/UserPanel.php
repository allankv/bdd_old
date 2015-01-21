cd<?php
include_once 'protected/controllers/logic/UserPanelLogic.php';

class UserPanel extends CWidget {
    public function run() {
		
    	 $idGroup = Yii::app()->user->getGroupId();
        // Get Institution Codes
        $institutionCodes = WebbeeController::executaSQL(
                "select distinct(institutioncode),i.idinstitutioncode from specimen sp
				inner join  recordlevelelement  re ON re.idrecordlevelelement = sp.idrecordlevelelement
				inner join institutioncode i ON i.idinstitutioncode = re.idinstitutioncode
				where sp.idgroup = '$idGroup';"
                );

        //Render userPanel page
        $this->render('userPanel',array(
            'icCodes' => $institutionCodes,
        ));


        //Translate the site
        //Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

        
        /*$institutions = WebbeeController::executaSQL(
                "select institutioncode, collectioncode, institutioncodes.idinstitutioncode, collectioncodes.idcollectioncode from recordlevelelements, institutioncodes, collectioncodes where
                    recordlevelelements.idcollectioncode = collectioncodes.idcollectioncode and
                    recordlevelelements.idinstitutioncode = institutioncodes.idinstitutioncode
                    group by institutioncode, collectioncode, institutioncodes.idinstitutioncode, collectioncodes.idcollectioncode
                    order by institutioncode, collectioncode");*/


        /*//Conta numero de Institui��es
        foreach($institutions as $value)
            $institutions_in[]=$value['idinstitutioncode'];

        //Conta numero de Institui��es
        foreach($institutions as $value)
            $institutions_co[]=$value['idcollectioncode'];

        //Faz a condicao para as colecoes selecionadas, so se for enviada a consulta
        $condinstitution="";

        //Pega os IDs de Todas Cole��es de Uma institui��o Selecionada
        foreach($institutions as $key => $value) {
            if(($_POST['institution'.$value['idinstitutioncode'].'check']==$value['idinstitutioncode'])) {
                if($condinstitution) $condinstitution=$condinstitution." or ";
                $condinstitution=$condinstitution." collectioncodes.idcollectioncode=".$value['idcollectioncode']." ";
            }
        }

        //Pega os IDs das Cole��es Selecionadas Individualmente
        foreach($institutions as $key => $value) {
            if(($_POST['collection'.$value['idcollectioncode'].'check']==$value['idcollectioncode'])) {
                if($condinstitution) $condinstitution=$condinstitution." or ";
                $condinstitution=$condinstitution." collectioncodes.idcollectioncode=".$value['idcollectioncode']." ";
            }
        }

        if($condinstitution) $condinstitution="and ($condinstitution)";


        //Pesquisa Coordenadas Geograficas das Colecoes
        $occurences_geocoord = WebbeeController::executaSQL(
                "select scientificname, higherclassification, institutioncode, collectioncodes.idcollectioncode, collectioncode, catalognumber, recordlevelelements.idrecordlevelelements, decimallatitude, decimallongitude
                from recordlevelelements,geospatialelements, institutioncodes, collectioncodes, occurrenceelements,
                localityelements left join municipality on (localityelements.idmunicipality=municipality.idmunicipality),
                taxonomicelements left join scientificnames on (taxonomicelements.idscientificname=scientificnames.idscientificname)
                where recordlevelelements.idgeospatialelements=geospatialelements.idgeospatialelements
                and taxonomicelements.idtaxonomicelements=recordlevelelements.idtaxonomicelements
                and localityelements.idlocalityelements=recordlevelelements.idlocalityelements
                and occurrenceelements.idoccurrenceelements=recordlevelelements.idoccurrenceelements
                and collectioncodes.idcollectioncode=recordlevelelements.idcollectioncode
                and institutioncodes.idinstitutioncode=recordlevelelements.idinstitutioncode $condinstitution");

        //Porcentagem BasisOfRecord
        $basisofrecods = WebbeeController::executaSQL(
                "select count (basisofrecord), basisofrecord
                    from basisofrecords, recordlevelelements
                    where basisofrecords.idbasisofrecord=recordlevelelements.idbasisofrecord
                    group by basisofrecord");


        //$preserved_count = count();

        //Pesquisa Coordenadas Geograficas das Colecoes
        $occurences = WebbeeController::executaSQL(
                "select recordlevelelements.idrecordlevelelements
                from recordlevelelements,institutioncodes, collectioncodes
                where collectioncodes.idcollectioncode=recordlevelelements.idcollectioncode
                and institutioncodes.idinstitutioncode=recordlevelelements.idinstitutioncode $condinstitution");

        $media_total_count = count(WebbeeController::executaSQL("select idmedia from media"));
        $media_associated_count = count(WebbeeController::executaSQL("select idrecordlevelelements from mediarecordlevel"));

        $reference_total_count = count(WebbeeController::executaSQL("select idreferenceselements from referenceselements"));
        $reference_associated_count = count(WebbeeController::executaSQL("select idrecordlevelelements from referencerecordlevel"));


        $interaction_total_count= count(WebbeeController::executaSQL("select idinteractionelements from interactionelements"));
        
        print_r($geocoord_co);
         *
         * /Render map
        $this->render('userPanel',array(
                'media_total_count'=>$media_total_count,
                'media_associated_count'=>$media_associated_count,
                'reference_total_count'=>$reference_total_count,
                'reference_associated_count'=>$reference_associated_count,
                'interaction_total_count'=>$interaction_total_count,
                'basisofrecors'=>$basisofrecord,
                'occurences_geocoord'=>$occurences_geocoord,
                'institutions'=>$institutions,
                'incount'=>count(array_unique($institutions_in)),
                'cocount'=>count(array_unique($institutions_co)),
                'total_occurrences_count'=>count(WebbeeController::executaSQL("select idrecordlevelelements from recordlevelelements")),
                'occurences'=>$occurences,
                'occurrences_count'=>count($occurences),
                'occurrences_plotted'=>count($occurences_geocoord)));
//Renderizacao*/

        //ini_set('max_execution_time','60000000000000');
        //ini_set("memory_limit","1280000M");
        //$this->render('importarExcel',array('media_total_count'=>$media_total_count));

    }
}

//        $preserveds = WebbeeController::executaSQL("select count(idrecordlevelelements) from recordlevelelements where recordlevelelements.idbasisofrecord=17");
//        $occurences = WebbeeController::executaSQL("select count(idrecordlevelelements) from recordlevelelements where recordlevelelements.idbasisofrecord=16");




?>