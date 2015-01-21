<?php
class TaxonomicElementLogic {
    public function autoSuggestionHierarchy($ar) {
        $c = array();
        $rs = array();
        $scientificNameWhere = '';
        $kingdomWhere = '';
        $phylumWhere = '';
        $classWhere = '';
        $orderWhere = '';
        $familyWhere = '';
        $genusWhere = '';
        $specificEpithetWhere = '';
        $infraspecificEpithetWhere = '';
        $subgenusWhere = '';

        $id = '';
        $fields = '';

        if($ar->idkingdom!=null) {
            $id = $id.'t.idkingdom, ';
            $field = $field.'kingdom.kingdom, ';
            $kingdomWhere = $kingdomWhere.' t.idkingdom = '.$ar->idkingdom;
        }
        if($ar->idphylum!=null) {
            $id = $ar->idkingdom!=null?$id:$id.'t.idkingdom, ';
            $field = $ar->idkingdom!=null?$field:$field.'kingdom.kingdom, ';
            $id = $id.'t.idphylum, ';
            $field = $field.'phylum.phylum, ';
            $phylumWhere = $phylumWhere.' t.idphylum = '.$ar->idphylum;
        }
        if($ar->idclass!=null) {
            $id = $ar->idphylum!=null?$id:$id.'t.idphylum, ';
            $id = $ar->idkingdom!=null?$id:$id.'t.idkingdom, ';
            $field = $ar->idphylum!=null?$field:$field.'phylum.phylum, ';
            $field = $ar->idkingdom!=null?$field:$field.'kingdom.kingdom, ';
            $id = $id.'t.idclass, ';
            $field = $field.'"class"."class" as class_, ';
            $classWhere = $classWhere.' t.idclass = '.$ar->idclass;
        }
        if($ar->idorder!=null) {
            $id = $ar->idphylum!=null?$id:$id.'t.idphylum, ';
            $id = $ar->idkingdom!=null?$id:$id.'t.idkingdom, ';
            $id = $ar->idclass!=null?$id:$id.'t.idclass, ';
            $field = $ar->idphylum!=null?$field:$field.'phylum.phylum, ';
            $field = $ar->idkingdom!=null?$field:$field.'kingdom.kingdom, ';
            $field = $ar->idclass!=null?$field:$field.'"class"."class", ';
            $id = $id.'t.idorder, ';
            $field = $field.'"order"."order", ';
            $orderWhere = $orderWhere.' t.idorder = '.$ar->idorder;
        }
        if($ar->idfamily!=null) {
            $id = $ar->idphylum!=null?$id:$id.'t.idphylum, ';
            $id = $ar->idkingdom!=null?$id:$id.'t.idkingdom, ';
            $id = $ar->idclass!=null?$id:$id.'t.idclass, ';
            $id = $ar->idorder!=null?$id:$id.'t.idorder, ';
            $field = $ar->idphylum!=null?$field:$field.'phylum.phylum, ';
            $field = $ar->idkingdom!=null?$field:$field.'kingdom.kingdom, ';
            $field = $ar->idclass!=null?$field:$field.'"class"."class", ';
            $field = $ar->idorder!=null?$field:$field.'"order"."order", ';
            $id = $id.'t.idfamily, ';
            $field = $field.'family.family, ';
            $familyWhere = $familyWhere.' t.idfamily = '.$ar->idfamily;
        }
        if($ar->idgenus!=null) {
            $id = $ar->idphylum!=null?$id:$id.'t.idphylum, ';
            $id = $ar->idkingdom!=null?$id:$id.'t.idkingdom, ';
            $id = $ar->idclass!=null?$id:$id.'t.idclass, ';
            $id = $ar->idorder!=null?$id:$id.'t.idorder, ';
            $id = $ar->idfamily!=null?$id:$id.'t.idfamily, ';
            $field = $ar->idphylum!=null?$field:$field.'phylum.phylum, ';
            $field = $ar->idkingdom!=null?$field:$field.'kingdom.kingdom, ';
            $field = $ar->idclass!=null?$field:$field.'"class"."class", ';
            $field = $ar->idorder!=null?$field:$field.'"order"."order", ';
            $field = $ar->idfamily!=null?$field:$field.'family.family, ';
            $id = $id.'t.idgenus, ';
            $field = $field.'genus.genus, ';
            $genusWhere = $genusWhere.' t.idgenus = '.$ar->idgenus;
        }
        if($ar->idsubgenus!=null) {
            $id = $ar->idphylum!=null?$id:$id.'t.idphylum, ';
            $id = $ar->idkingdom!=null?$id:$id.'t.idkingdom, ';
            $id = $ar->idclass!=null?$id:$id.'t.idclass, ';
            $id = $ar->idorder!=null?$id:$id.'t.idorder, ';
            $id = $ar->idfamily!=null?$id:$id.'t.idfamily, ';
            $id = $ar->genus!=null?$id:$id.'t.idgenus, ';
            $field = $ar->idphylum!=null?$field:$field.'phylum.phylum, ';
            $field = $ar->idkingdom!=null?$field:$field.'kingdom.kingdom, ';
            $field = $ar->idclass!=null?$field:$field.'"class"."class", ';
            $field = $ar->idorder!=null?$field:$field.'"order"."order", ';
            $field = $ar->idfamily!=null?$field:$field.'family.family, ';
            $field = $ar->idgenus!=null?$field:$field.'genus.genus, ';
            $id = $id.'t.idsubgenus, ';
            $field = $field.'subgenus.subgenus, ';
            $subgenusWhere = $subgenusWhere.' t.idsubgenus = '.$ar->idsubgenus;
        }
        if($ar->idspecificepithet!=null) {
            $id = $ar->idphylum!=null?$id:$id.'t.idphylum, ';
            $id = $ar->idkingdom!=null?$id:$id.'t.idkingdom, ';
            $id = $ar->idclass!=null?$id:$id.'t.idclass, ';
            $id = $ar->idorder!=null?$id:$id.'t.idorder, ';
            $id = $ar->idfamily!=null?$id:$id.'t.idfamily, ';
            $id = $ar->idgenus!=null?$id:$id.'t.idgenus, ';
            $id = $ar->idsubgenus!=null?$id:$id.'t.idsubgenus, ';
            $field = $ar->idphylum!=null?$field:$field.'phylum.phylum, ';
            $field = $ar->idkingdom!=null?$field:$field.'kingdom.kingdom, ';
            $field = $ar->idclass!=null?$field:$field.'"class"."class", ';
            $field = $ar->idorder!=null?$field:$field.'"order"."order", ';
            $field = $ar->idfamily!=null?$field:$field.'family.family, ';
            $field = $ar->idgenus!=null?$field:$field.'genus.genus, ';
            $field = $ar->idsubgenus!=null?$field:$field.'subgenus.subgenus, ';
            $id = $id.'t.idspecificepithet, ';
            $field = $field.'specificepithet.specificepithet, ';
            $specificEpithetWhere = $specificEpithetWhere.' t.idspecificepithet = '.$ar->idspecificepithet;
        }
        if($ar->idinfraspecificepithet!=null) {
            $id = $ar->idphylum!=null?$id:$id.'t.idphylum, ';
            $id = $ar->idkingdom!=null?$id:$id.'t.idkingdom, ';
            $id = $ar->idclass!=null?$id:$id.'t.idclass, ';
            $id = $ar->idorder!=null?$id:$id.'t.idorder, ';
            $id = $ar->idfamily!=null?$id:$id.'t.idfamily, ';
            $id = $ar->idgenus!=null?$id:$id.'t.idgenus, ';
            $id = $ar->idsubgenus!=null?$id:$id.'t.idsubgenus, ';
            $id = $ar->idspecificepithet!=null?$id:$id.'t.idspecificepithet, ';
            $field = $ar->idphylum!=null?$field:$field.'phylum.phylum, ';
            $field = $ar->idkingdom!=null?$field:$field.'kingdom.kingdom, ';
            $field = $ar->idclass!=null?$field:$field.'"class"."class", ';
            $field = $ar->idorder!=null?$field:$field.'"order"."order", ';
            $field = $ar->idfamily!=null?$field:$field.'family.family, ';
            $field = $ar->idgenus!=null?$field:$field.'genus.genus, ';
            $field = $ar->idsubgenus!=null?$field:$field.'subgenus.subgenus, ';
            $field = $ar->idspecificepithet!=null?$field:$field.'specificepithet.specificepithet, ';
            $id = $id.'t.idinfraspecificepithet, ';
            $field = $field.'infraspecificepithet.infraspecificepithet, ';
            $infraspecificEpithetWhere = $infraspecificEpithetWhere.' t.idinfraspecificepithet = '.$ar->idinfraspecificepithet;
        }
        if($ar->idscientificname!=null) {
            $id = $ar->idphylum!=null?$id:$id.'t.idphylum, ';
            $id = $ar->idkingdom!=null?$id:$id.'t.idkingdom, ';
            $id = $ar->idclass!=null?$id:$id.'t.idclass, ';
            $id = $ar->idorder!=null?$id:$id.'t.idorder, ';
            $id = $ar->idfamily!=null?$id:$id.'t.idfamily, ';
            $id = $ar->idgenus!=null?$id:$id.'t.idgenus, ';
            $id = $ar->idsubgenus!=null?$id:$id.'t.idsubgenus, ';
            $id = $ar->idspecificepithet!=null?$id:$id.'t.idspecificepithet, ';
            $id = $ar->idinfraspecificepithet!=null?$id:$id.'t.idinfraspecificepithet, ';
            $field = $ar->idphylum!=null?$field:$field.'phylum.phylum, ';
            $field = $ar->idkingdom!=null?$field:$field.'kingdom.kingdom, ';
            $field = $ar->idclass!=null?$field:$field.'"class"."class", ';
            $field = $ar->idorder!=null?$field:$field.'"order"."order", ';
            $field = $ar->idfamily!=null?$field:$field.'family.family, ';
            $field = $ar->idgenus!=null?$field:$field.'genus.genus, ';
            $field = $ar->idsubgenus!=null?$field:$field.'subgenus.subgenus, ';
            $field = $ar->idspecificepithet!=null?$field:$field.'specificepithet.specificepithet, ';
            $field = $ar->idinfraspecificepithet!=null?$field:$field.'infraspecificepithet.infraspecificepithet, ';
            $id = $id.'t.idscientificname, ';
            $field = $field.'scientificname.scientificname, ';
            $scientificNameWhere = $scientificNameWhere.' t.idscientificname = '.$ar->idscientificname;
        }        

        $scientificNameWhere = $scientificNameWhere!=''?' AND ('.$scientificNameWhere.') ':'';
        $kingdomWhere = $kingdomWhere!=''?' AND ('.$kingdomWhere.') ':'';
        $phylumWhere = $phylumWhere!=''?' AND ('.$phylumWhere.') ':'';
        $classWhere = $classWhere!=''?' AND ('.$classWhere.') ':'';
        $orderWhere = $orderWhere!=''?' AND ('.$orderWhere.') ':'';
        $familyWhere = $familyWhere!=''?' AND ('.$familyWhere.') ':'';
        $genusWhere = $genusWhere!=''?' AND ('.$genusWhere.') ':'';
        $specificEpithetWhere = $specificEpithetWhere!=''?' AND ('.$specificEpithetWhere.') ':'';
        $infraspecificEpithetWhere = $infraspecificEpithetWhere!=''?' AND ('.$infraspecificEpithetWhere.') ':'';
        $subgenusWhere = $subgenusWhere!=''?' AND ('.$subgenusWhere.') ':'';

        $id = preg_replace("/,$/", "", trim($id));
        $field = preg_replace("/,$/", "", trim($field));

        $c['select'] = "SELECT DISTINCT ON ($id) $id, ";//t.idscientificname, t.idkingdom, t.idphylum, t.idclass, t.idorder, t.idfamily, t.idgenus, t.idspecificepithet, t.idinfraspecificepithet, t.idsubgenus, ";
        $c['select'] = $c['select']." $field ";//scientificname.scientificname, kingdom.kingdom, phylum.phylum, "class"."class" as class_, "order"."order", family.family, genus.genus, specificepithet.specificepithet, infraspecificepithet.infraspecificepithet, subgenus.subgenus ';
        $c['from'] = ' FROM taxonomicelement t ';
        $c['join'] = $c['join'].' LEFT JOIN kingdom ON t.idkingdom = kingdom.idkingdom ';
        $c['join'] = $c['join'].' LEFT JOIN phylum ON t.idphylum = phylum.idphylum ';
        $c['join'] = $c['join'].' LEFT JOIN "class" ON t.idclass = "class".idclass ';
        $c['join'] = $c['join'].' LEFT JOIN "order" ON t.idorder = "order".idorder ';
        $c['join'] = $c['join'].' LEFT JOIN family ON t.idfamily = family.idfamily ';
        $c['join'] = $c['join'].' LEFT JOIN genus ON t.idgenus = genus.idgenus ';
        $c['join'] = $c['join'].' LEFT JOIN subgenus ON t.idsubgenus = subgenus.idsubgenus ';
        $c['join'] = $c['join'].' LEFT JOIN specificepithet ON t.idspecificepithet = specificepithet.idspecificepithet ';
        $c['join'] = $c['join'].' LEFT JOIN infraspecificepithet ON t.idinfraspecificepithet = infraspecificepithet.idinfraspecificepithet ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname ON t.idscientificname = scientificname.idscientificname ';
        $c['where'] = ' WHERE 1 = 1 '.$scientificNameWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$specificEpithetWhere.$infraspecificEpithetWhere.$subgenusWhere;
        //$c['orderby'] = ' ORDER BY scientific.title ';
        //$c['limit'] = ' limit '.$filter['limit'];
        //$c['offset'] = ' offset '.$filter['offset'];
        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];//.$c['orderby'].$c['limit'].$c['offset'];
        // faz consulta e manda para list
        //echo $sql;die();
        if($id!='')
            $rs['list'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
    public function fillDependency($ar) {
        if($ar->scientificname==null) {
            $ar->scientificname = ScientificNameAR::model();
        }
        if($ar->morphospecies==null) {
            $ar->morphospecies = MorphospeciesAR::model();
        }
        if($ar->kingdom==null) {
            $ar->kingdom = KingdomAR::model();
        }
        if($ar->phylum==null) {
            $ar->phylum = PhylumAR::model();
        }
        if($ar->class==null) {
            $ar->class = ClassAR::model();
        }
        if($ar->order==null) {
            $ar->order = OrderAR::model();
        }
        if($ar->family==null) {
            $ar->family = FamilyAR::model();
        }
        if($ar->genus==null) {
            $ar->genus = GenusAR::model();
        }
        if($ar->specificepithet==null) {
            $ar->specificepithet = SpecificEpithetAR::model();
        }
        if($ar->infraspecificepithet==null) {
            $ar->infraspecificepithet = InfraspecificEpithetAR::model();
        }
        if($ar->taxonrank==null) {
            $ar->taxonrank = TaxonRankAR::model();
        }
        if($ar->scientificnameauthorship==null) {
            $ar->scientificnameauthorship = ScientificNameAuthorshipAR::model();
        }
        if($ar->nomenclaturalcode==null) {
            $ar->nomenclaturalcode = NomenclaturalCodeAR::model();
        }
        if($ar->acceptednameusage==null) {
            $ar->acceptednameusage = AcceptedNameUsageAR::model();
        }
        if($ar->parentnameusage==null) {
            $ar->parentnameusage = ParentNameUsageAR::model();
        }
        if($ar->originalnameusage==null) {
            $ar->originalnameusage = OriginalNameUsageAR::model();
        }
        if($ar->nameaccordingto==null) {
            $ar->nameaccordingto = NameAccordingToAR::model();
        }
        if($ar->namepublishedin==null) {
            $ar->namepublishedin = NamePublishedInAR::model();
        }
        if($ar->taxonconcept==null) {
            $ar->taxonconcept = TaxonConceptAR::model();
        }
        if($ar->subgenus==null) {
            $ar->subgenus = SubgenusAR::model();
        }
        if($ar->taxonomicstatus==null) {
            $ar->taxonomicstatus = TaxonomicStatusAR::model();
        }
        if($ar->morphospecies==null) {
            $ar->morphospecies = MorphospeciesAR::model();
        }
        if($ar->tribe==null) {
            $ar->tribe = TribeAR::model();
        }
        if($ar->subtribe==null) {
            $ar->subtribe = SubtribeAR::model();
        }
        if($ar->speciesname==null) {
            $ar->speciesname = SpeciesNameAR::model();
        }
        if($ar->subspecies==null) {
            $ar->subspecies = SubspeciesAR::model();
        }

        return $ar;
    }
    public function save($ar) {
        $rs = array ();
        $rs['success'] = true;
        $rs['operation'] = $ar->idtaxonomicelement == null?'create':'update';
        $ar->setIsNewRecord($rs['operation']=='create');
        $rs['msg'] = $rs['operation'].' success';
        $ar->idtaxonomicelement = $rs['operation']=='create'?null:$ar->idtaxonomicelement;
        $ar->save();
        return $ar->idtaxonomicelement;
    }
    public function delete($id) {
        $ar = TaxonomicElementAR::model();
        $ar = $ar->findByPk($id);
        $ar->delete();
    }
    public function setAttributes($p) {
        $ar = TaxonomicElementAR::model();
        $p['idscientificname']=$p['idscientificname']==''?null:$p['idscientificname'];
        $p['idkingdom']=$p['idkingdom']==''?null:$p['idkingdom'];
        $p['idphylum']=$p['idphylum']==''?null:$p['idphylum'];
        $p['idclass']=$p['idclass']==''?null:$p['idclass'];
        $p['idorder']=$p['idorder']==''?null:$p['idorder'];
        $p['idfamily']=$p['idfamily']==''?null:$p['idfamily'];
        $p['idgenus']=$p['idgenus']==''?null:$p['idgenus'];
        $p['idspecificepithet']=$p['idspecificepithet']==''?null:$p['idspecificepithet'];
        $p['idinfraspecificepithet']=$p['idinfraspecificepithet']==''?null:$p['idinfraspecificepithet'];
        $p['idtaxonrank']=$p['idtaxonrank']==''?null:$p['idtaxonrank'];
        $p['idscientificnameauthorship']=$p['idscientificnameauthorship']==''?null:$p['idscientificnameauthorship'];
        $p['idnomenclaturalcode']=$p['idnomenclaturalcode']==''?null:$p['idnomenclaturalcode'];
        $p['idacceptednameusage']=$p['idacceptednameusage']==''?null:$p['idacceptednameusage'];
        $p['idparentnameusage']=$p['idparentnameusage']==''?null:$p['idparentnameusage'];
        $p['idoriginalnameusage']=$p['idoriginalnameusage']==''?null:$p['idoriginalnameusage'];
        $p['idnameaccordingto']=$p['idnameaccordingto']==''?null:$p['idnameaccordingto'];
        $p['idnamepublishedin']=$p['idnamepublishedin']==''?null:$p['idnamepublishedin'];
        $p['idtaxonconcept']=$p['idtaxonconcept']==''?null:$p['idtaxonconcept'];
        $p['idsubgenus']=$p['idsubgenus']==''?null:$p['idsubgenus'];
        $p['idtaxonomicstatus']=$p['idtaxonomicstatus']==''?null:$p['idtaxonomicstatus'];
        $p['idmorphospecies']=$p['idmorphospecies']==''?null:$p['idmorphospecies'];
        $p['idtribe']=$p['idtribe']==''?null:$p['idtribe'];
        $p['idsubtribe']=$p['idsubtribe']==''?null:$p['idsubtribe'];
        $p['idspeciesname']=$p['idspeciesname']==''?null:$p['idspeciesname'];
        $p['idsubspecies']=$p['idsubspecies']==''?null:$p['idsubspecies'];
        
        $ar->setAttributes($p,false);

        return $this->fillDependency($ar);
    }
}
?>
