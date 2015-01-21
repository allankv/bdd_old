<?php
class FileLogic {

    public function save($ar) {
    	
		//$ar->filename = $_FILES['file']['name'];
		//$ar->path = 'images/uploaded';
		//$ar->size = $_FILES['file']['size']; 
		//$ar->extension = $this->getExtensaoArquivo($_FILES['file']['name']);

		$rs = array ();
		
		if($ar->validate()) {
			$rs['success'] = true;
			
            $rs['operation'] = $ar->idfile == null?'Create':'Update';
            $ar->setIsNewRecord($rs['operation']=='Create');
            $aux = array();
            $aux[] = $rs['operation'].' success';
            $rs['msg'] = $aux;
            $ar->idfile = $ar->getIsNewRecord()?null:$ar->idfile;
            if($ar->save()){            
            
				//realiza o upload do arquivo	
				//$rs['msg'] = $this->enviarArquivo("images/uploaded",$ar->idfile.".".$ar->extension);
				
				//caso tenha ocorrido um problema ao enviar o arquivo, exclui o registro file
				//if($rs['msg']<>""){
				
				//	$ar->delete();
				
				//}else{
				
					//indica o valor do filesystemname e atualiza o registro
				//	$ar->filesystemname = $ar->idfile.".".$ar->extension;
				//	$ar->update();
				
				//}            
            
            }
            $rs['fileURL'] = $ar->path.$ar->filename;
            $rs['id'] = $ar->idfile;
            
            return $rs;
            			
		}else{
		
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
    
    public function delete($id) {   
        $ar = FileAR::model();
        $ar = $ar->findByPk($id);

        $msgErros = $this->excluirArquivoFisicamente($ar->path, $ar->filesystemname);
        
        //Caso tenho excluido corretamento o arquivo fisicamente, apaga o registro		
		if($msgErros==""){        
        
        	$ar->delete();    
			
		}
		
		return $msgErros;	    
    
    }
    
    
	public function getExtensaoArquivo($_nomeArquivo){
	
		return strtolower(substr($_nomeArquivo,strripos($_nomeArquivo,".")+1,strlen($_nomeArquivo)-1));
	
	}
	
	
	private function excluirArquivoFisicamente($diretorio, $nomeArquivo){		
			
		try {
	
			unlink(trim($diretorio."/".$nomeArquivo));
		
		}catch(Exception $e){
			return $e->getMessage();
		}
		
		return "";
	
	} 
	
	private function enviarArquivo($destino, $nomeDestino){
	
		$msgErro = "";
	
		if(!$_FILES){
			$msgErro .= "Nenhum arquivo enviado!";
		}else{
			$file_name = $_FILES['file']['name'];
			$file_type = $_FILES['file']['type'];
			$file_size = $_FILES['file']['size'];
			$file_tmp_name = $_FILES['file']['tmp_name'];
			$error = $_FILES['file']['error'];
		}
		
		switch ($error){
			case 0:
				break;
			case 1:
				$msgErro .= "O tamanho do arquivo é maior que o definido nas configurações do PHP! ";
				break;
			case 2:
				$msgErro .= "O tamanho do arquivo é maior do que o permitido!";
				break;
			case 3:
				$msgErro .= "O upload não foi concluído!";
				break;
			case 4:
				$msgErro .= "O upload não foi feito!";
				break;
		}
		
		if($error == 0){
			if(!is_uploaded_file($file_tmp_name)){
				$msgErro .= "Erro ao processar arquivo!";
			}else{
		
				if(!move_uploaded_file($file_tmp_name,$destino."/".$nomeDestino)){
					$msgErro .= "Não foi possível salvar o arquivo!";
				}
//				else{
//					echo 'Processo concluído com sucesso!<br>';
//					echo "Nome do arquivo: $file_name<br>";
//					echo "Tipo de arquivo: $file_type<br>";
//					echo "Tamanho em byte: $file_size<br>";
//				}
			}
		}
	
	
		return $msgErro;
	}	
	
    public function fillDependency($ar) {
        return $ar;
    }	
    

}
?>
