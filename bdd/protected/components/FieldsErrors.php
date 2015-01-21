<?php

class FieldsErrors extends CWidget
{

	//public $models = array();
        public $msg = array();

	public function run()
	{
		//if(Yii::app()->request->isPostRequest){
		
			/*$arrayErrorMessages = array();
			
			//percorre todos os models
			foreach($this->models as $n=>$model):
			
				//verifica a validacao dos campos baseado nas regras do model
				if(!$model->validate()){		
					
					//obtem o array de erros e percorre cada item
					foreach($model->getErrors() as $n=>$mensagem):				
	
						if($mensagem[0]!=""){
											
							//armazena todas as mensagens no array arrayErrorMessages
							array_push($arrayErrorMessages,$mensagem[0]);
						}
					
					endforeach;				
					
				}
			
			endforeach;	
		*/
			//mostra os erros apenas se tiver conteudo no array de mensagens
			//if(count($arrayErrorMessages)>0){
                        if(count($this->msg)>0){
				$this->render('fieldsErrors',array('msg'=>$this->msg));
				
			}
		//}
	}
}

?>