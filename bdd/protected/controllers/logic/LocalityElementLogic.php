<?php
include_once 'GeoreferencedByLogic.php';
include_once 'GeoreferenceSourceLogic.php';
class LocalityElementLogic {
    public function search($q) {
        $ar = LocalityElementAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "highergeograph ilike '%$q%' OR difference(highergeograph, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function fillDependency($ar) {
        if($ar->country==null) {
            $ar->country = CountryAR::model();
        }
        if($ar->stateprovince==null) {
            $ar->stateprovince = StateProvinceAR::model();
        }
        if($ar->county==null) {
            $ar->county = CountyAR::model();
        }
        if($ar->municipality==null) {
            $ar->municipality = MunicipalityAR::model();
        }
        if($ar->locality==null) {
            $ar->locality = LocalityAR::model();
        }
        if($ar->continent==null) {
            $ar->continent = ContinentAR::model();
        }
        if($ar->island==null) {
            $ar->island = IslandAR::model();
        }
        if($ar->islandgroup==null) {
            $ar->islandgroup = IslandGroupAR::model();
        }
        if($ar->habitat==null) {
            $ar->habitat = HabitatLocalityAR::model();
        }
        if($ar->waterbody==null) {
            $ar->waterbody = WaterBodyAR::model();
        }
        if($ar->site_==null) {
            $ar->site_ = Site_AR::model();
        }
        return $ar;
    }
    public function save($ar) {
        $rs = array ();
        $rs['success'] = true;
        $rs['operation'] = $ar->idlocalityelement == null?'create':'update';
        $ar->setIsNewRecord($rs['operation']=='create');
        $rs['msg'] = $rs['operation'].' success';
        $ar->idlocalityelement = $ar->getIsNewRecord()?null:$ar->idlocalityelement;
        $ar->save();
        return $ar->idlocalityelement;
    }
    public function delete($id) {
        $ar = LocalityElementAR::model();
        $ar = $ar->findByPk($id);
        $l = new GeoreferencedByLogic();
        $l->deleteLocalityRecord($id);
        $l = new GeoreferenceSourceLogic();
        $l->deleteLocalityRecord($id);
        $ar->delete();
    }
    public function setAttributes($p) {
        $ar = LocalityElementAR::model();
        $p['idcountry']=$p['idcountry']==''?null:$p['idcountry'];
        $p['idstateprovince']=$p['idstateprovince']==''?null:$p['idstateprovince'];
        $p['idcounty']=$p['idcounty']==''?null:$p['idcounty'];
        $p['idmunicipality']=$p['idmunicipality']==''?null:$p['idmunicipality'];
        $p['idlocality']=$p['idlocality']==''?null:$p['idlocality'];
        $p['idcontinent']=$p['idcontinent']==''?null:$p['idcontinent'];
        $p['idwaterbody']=$p['idwaterbody']==''?null:$p['idwaterbody'];
        $p['idislandgroup']=$p['idislandgroup']==''?null:$p['idislandgroup'];
        $p['idisland']=$p['idisland']==''?null:$p['idisland'];
        $p['idhabitat']=$p['idhabitat']==''?null:$p['idhabitat'];
        $p['idsite_']=$p['idsite_']==''?null:$p['idsite_'];
        $ar->setAttributes($p,false);
        return $this->fillDependency($ar);
    }
}
?>
