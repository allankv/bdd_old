<?php
class ContributorLogic {
    var $mainAtt = 'contributor';
    public function search($q) {
        $ar = ContributorAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();
        $ln= array ("key"=>"","value"=>$q." <br>(New)</br>");
            $result[] = $ln;
        foreach ($rs as $n=>$ar) {
            $ln= array ("key"=>"".$ar->idcontributor,"value"=>$ar->contributor);
            $result[] = $ln;
        }
        return $result;
    }
    public function suggestion($q) {
        $ar = ContributorAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new ContributorAR();
        $rs = array();

        $ar->contributor = $field;
        $ar->idcontributor = $id;

        if(isset($ar->idcontributor)) {
            $returnAR = ContributorAR::model()->findByPk($ar->idcontributor);
        }else {
            $ar->contributor = trim($ar->contributor);
            $returnAR = ContributorAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->contributor."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idcontributor;
            $rs['field'] = $returnAR->contributor;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = ContributorAR::model();
        $ar->contributor = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idcontributor == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idcontributor;
            $rs['field'] = $rs['ar']->contributor;
            $rs['ar'] = $rs['ar']->getAttributes();

            return $rs;
        }else {
            $erros = array ();
            foreach($ar->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            $rs['success'] = false;
            $rs['msg'] = $erros;
            return $rs;
        }
    }
    public function getContributorBySpecies($ar) {
        $nnList = SpeciesContributorAR::model()->findAll('idspecies='.$ar->idspecies);
        $contributorList = array();
        foreach ($nnList as $n=>$ar) {
            $contributorList[] = ContributorAR::model()->findByPk($ar->idcontributor);
        }
        return $contributorList;
    }
    public function saveSpeciesNN($idContributor,$idSpecies) {
        if(SpeciesContributorAR::model()->find(" idcontributor=$idContributor AND idspecies=$idSpecies ")==null) {
            $ar = SpeciesContributorAR::model();
            $ar->idcontributor = $idContributor;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idContributor,$idSpecies) {
        $ar = SpeciesContributorAR::model();
        $ar = $ar->find(" idcontributor=$idContributor AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesContributorAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
