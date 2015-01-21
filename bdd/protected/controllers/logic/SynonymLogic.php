<?php
class SynonymLogic {
    var $mainAtt = 'synonym';
    public function search($q) {
        $ar = SynonymAR::model();
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
            $ln= array ("key"=>"".$ar->idsynonym,"value"=>$ar->synonym);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SynonymAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SynonymAR();
        $rs = array();

        $ar->synonym = $field;
        $ar->idsynonym = $id;

        if(isset($ar->idsynonym)) {
            $returnAR = SynonymAR::model()->findByPk($ar->idsynonym);
        }else {
            $ar->synonym = trim($ar->synonym);
            $returnAR = SynonymAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->synonym."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsynonym;
            $rs['field'] = $returnAR->synonym;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = SynonymAR::model();
        $ar->synonym = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsynonym == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsynonym;
            $rs['field'] = $rs['ar']->synonym;
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
    public function getSynonymBySpecies($ar) {
        $nnList = SpeciesSynonymAR::model()->findAll('idspecies='.$ar->idspecies);
        $synonymList = array();
        foreach ($nnList as $n=>$ar) {
            $synonymList[] = SynonymAR::model()->findByPk($ar->idsynonym);
        }
        return $synonymList;
    }
    public function saveSpeciesNN($idSynonym,$idSpecies) {
        if(SpeciesSynonymAR::model()->find("idsynonym=$idSynonym AND idspecies=$idSpecies")==null) {
            $ar = SpeciesSynonymAR::model();
            $ar->idsynonym = $idSynonym;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idSynonym,$idSpecies) {
        $ar = SpeciesSynonymAR::model();
        $ar = $ar->find(" idsynonym=$idSynonym AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesSynonymAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
