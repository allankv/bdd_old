//To create new Logic from template:
//for example, for the Georeference Verification Status Logic,
//replace "TemplateUpperCase" with "GeoreferenceVerificationStatus" AND
//replace "templatelowercase" with "georeferenceverificationstatus".

//Be careful with NN fields - leave those functions as they are.

<?php
class TemplateUpperCaseLogic {
    var $mainAtt = 'templatelowercase';
    public function search($q) {
        $ar = TemplateUpperCaseAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idtemplatelowercase+"","label"=>$ar->templatelowercase,"value"=>$ar->templatelowercase);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = TemplateUpperCaseAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new TemplateUpperCaseAR();
        $rs = array();

        $ar->templatelowercase = $field;
        $ar->idtemplatelowercase = $id;

        if(isset($ar->idtemplatelowercase)) {
            $returnAR = TemplateUpperCaseAR::model()->findByPk($ar->idtemplatelowercase);
        }else {
            $ar->templatelowercase = trim($ar->templatelowercase);
            $returnAR = TemplateUpperCaseAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->templatelowercase."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idtemplatelowercase;
            $rs['field'] = $returnAR->templatelowercase;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = TemplateUpperCaseAR::model();
        $ar->templatelowercase = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtemplatelowercase == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idtemplatelowercase;
            $rs['field'] = $rs['ar']->templatelowercase;
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
}
?>
