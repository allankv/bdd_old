<?php

class LogLogic {
    public function save($ar) {
    	$ar->idgroup = Yii::app()->user->getGroupId();
    	
        $rs = array();
        if($ar->validate()) {
            $rs['success'] = true;
            $ar->setIsNewRecord(true);
            $aux = array();
            $aux[] = 'Successfully created log record '.$ar->idlog;
            $rs['msg'] = $aux;
            $ar->save();
            $rs['ar'] = $ar;
            return $rs;
        } else {
            $erros = array();
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
