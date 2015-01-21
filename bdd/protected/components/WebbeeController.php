<?php
class WebbeeController {

    /**
     * Retorna uma array que é resultado da consulta SQL passada como parametro
     */
    public static function executaSQL($sqlStatement) {
        $connection = Yii::app()->getDb();
        $connection->active = true;

        $dbCommand = $connection->createCommand($sqlStatement);
        $result = $dbCommand->queryAll(true);
        // Não descomentar código abaixo. Ele fecharia temporariamente a conexão da  aplicação com o banco de dados
        //$connection->active = false;
        return $result;
    }

    /**
     * Se o parametro for uma consulta SQL (SELECT, SHOW, DESCRIBE ou EXPLAIN), retorna uma array que é resultado da consulta SQL passada como parametro
     * Se o parametro passado for uma instrução SQL (INSERT, DELETE, UPDATE, etc), executa a instrução e retorna NULL;
     * Retorna FALSE caso ocorra qualquer erro e descreve o erro ocorrido.
     */
    public static function executaSQL2($sqlStatement) {
        $connection = mysql_connect("localhost",Yii::app()->getDb()->username,Yii::app()->getDb()->password);
        if (!$connection) echo 'Erro na Conexao com Servidor: '. mysql_error();


        if (!mysql_select_db("webbee", $connection)) echo 'Erro na Conexao com Banco de Dados: '. mysql_error();


        $result = mysql_query($sqlStatement, $connection);
        if (!$result) {
            echo	'Erro na Query '. mysql_errno() . ': ' . mysql_error();
            return false;
        }
        else if (is_resource($result)) {
            $retorno = array(1 => mysql_fetch_assoc($result));
            echo mysql_num_rows($result);
            for ($i=2; $i<=mysql_num_rows($result); $i++)
                $retorno[] = mysql_fetch_assoc($result);
        }
        mysql_close($connection);
        return $retorno;
    }

    /* Método retorna uma array baseado no array do método executaSQL, que também é um
	 * padrão do framework.
    */
    public function retornaArray($array, $nomeCampo) {
        foreach($array as $key=>$value) {
            $list[] = $value[$nomeCampo];
        }
        return $list;
    }

    public function retornaArrayChaveValor($array, $campoChave, $campoValor) {
        foreach($array as $key=>$value) {
            $list[$value[$campoChave]] = $value[$campoValor];
        }
        return $list;
    }

    /*
	 * Itera dentro da array procurando um valor determinado pelo parametro '$procurado'
	 * @Return Retorna true se encontrou, e false caso contrário
	 * @author Bruno Joia
    */
    public static function procuraEmArray($array, $procurado) {
        foreach($array as $value) {
            if (is_array($value) && $value != $procurado) {
                return WebbeeController::procuraEmArray($value, $procurado);
            }
            else if ($value == $procurado) {
                return true;
            }
        }
        return false;
    }

    public static function controlAccess() {
        if(!Yii::app()->user->isGuest) {
            $idUser = Yii::app()->user->id;
            $username = Yii::app()->user->name;

            // Armazena os atributos (ações) qe o usuário atual tem permissão de executar
            $attributes = WebbeeController::executaSQL(
                    "SELECT attribute FROM attributes A
			INNER JOIN groupattributes GA ON GA.\"idAttribute\" = A.\"idAttribute\"
			INNER JOIN users U ON U.\"idGroup\" = GA.\"idGroup\"		
             AND U.\"idUser\" = $idUser");

            // adapta o resultado anterior numa array mais simples e conveniente para o framework
            $attributes = WebbeeController::retornaArray($attributes, 'attribute');

            // Armazena as páginas (controllers) qe o usuário atual tem permissão de executar
            $pages = WebbeeController::executaSQL(
                    "SELECT page FROM pages P
			INNER JOIN grouppages GP ON GP.\"idPage\" = P.\"idPage\"
			INNER JOIN users U ON U.\"idGroup\" = GP.\"idGroup\"
			AND U.\"idUser\" = $idUser");

            // adapta o resultado anterior numa array mais simples e conveniente para o framework
            $pages = WebbeeController::retornaArray($pages, 'page');


            if(isset($attributes) and isset($pages)) {


                if (!WebbeeController::procuraEmArray($attributes, 'admin')) {
                    $access = array(
                            array('deny', //Restringe o acesso do usuário que logou no site. Consultar tabelas de acesso no banco de dados
                                    'actions'=>array('admin','create','validate'),
                                    'users'=>array($username),
                                    'controllers'=>array('users'),
                            ),
                            array('allow', //Restringe o acesso do usuário que logou no site. Consultar tabelas de acesso no banco de dados
                                    'actions'=>array('update','list','show'),
                                    'users'=>array($username),
                                    'controllers'=>array('users'),
                            )
                    );
                }

                $access[] = array('allow', //Define acesso do usuário que logou no site. Consultar tabelas de acesso no banco de dados
                        'actions'=>$attributes,
                        'users'=>array($username),
                        'controllers'=>$pages
                );
                $access[] = array('deny',  // deny all users
                        'users'=>array('*'),
                );

                return $access;
            }
        } else {
            return array(
                    array('deny',
                            'users'=>array('*'),
                    ),
            );
        }
    }

    /*
	 * Method returns array on success query execution, not sucess returns false
         * Used on Recordlevelelements and referenceselements controlle
    */
    public function getFieldElement($array, $model, $fieldreturn) {
        //@vars boolean defines if query can be executed.
        $execute_sql = false;
        //@vars boolean defines result of method
        $result = $executa_sql;

        //If array/model was not defined return false
        if($array===null) return $result;
        if($model===null) return $result;

        $table = $model->tableName();
        $sql = "SELECT $fieldreturn ";
        $sql .= "FROM  $table ";
        $sql .= "WHERE 'this' = 'this' ";
        foreach($array as $key=>$value) {
            if ($value !== "") {
                $sql .=	" AND $key = '$value'";
                $execute_sql = true;
            }
        }
        //echo $sql;
        if ($execute_sql) {
            $result = $model->findBySql($sql);
        }
        return $result;
    }

    /*
	 * Check whether array has all fields like null and return false, in the other hand return true
         * Used on Recordlevelelements and referenceselements controller
    */
    public function checkArrayNull($array) {

        //If array was not defined return false
        if($array===null) return false;

        foreach($array as $key=>$value) {
            if ($value !== "") {
                return true;
            }
        }
        return false;
    }

    /* Get id based on array of parameters
         * Can be any model
         * Used on Recordlevelelements and referenceselements controller
    */
    public function setIdElementOfRecord($AR, $fieldtoset, $model) {

        if($AR === null) return false;
        if($model === null) return false;

        $model->setAttribute("$fieldtoset", $AR->getAttribute("$fieldtoset"));
        $rec["$fieldtoset"] = $AR->getAttribute("$fieldtoset");

        return true;
    }

    public function changeFileName($from, $to, $dir) {
        if($from == "") return false;
        if($to == "") return false;
        if($dir == "") return false;

        $from = strtr($from, "*.&%><-_+=\/|", "");
        $to = strtr($to, "*.&%><-_+=\/|", "");
        $to = preg_replace("/\.php/", "xyz", $to);
        $dir = strtr($dir, "*.&%><-_+=\/|", "");

        //echo 'mv '.escapeshellarg("$dir$from").' '.escapeshellarg("$dir$to");
        exec('mv '.escapeshellarg("$dir$from").' '.escapeshellarg("$dir$to"), $output, $exec);
        if($exec == 0) {
            return true;
        }
        return false;
    }

    public function lastTaxa($model) {

        if(isset($model->taxonomicelement->scientificname->scientificname))
            return CHtml::encode($model->taxonomicelement->scientificname->scientificname)." <font style=\"font-size:11px;color:gray;\">(scientific name)</font>";
        else
        if(isset($model->taxonomicelement->subgenus->subgenus))
            return CHtml::encode($model->taxonomicelement->subgenus->subgenus)." <font style=\"font-size:11px;color:gray;\">(sub genus)</font>";
        else
        if(isset($model->taxonomicelement->genus->genus))
            return CHtml::encode($model->taxonomicelement->genus->genus)." <font style=\"font-size:11px;color:gray;\">(genus)</font>";
        else
        if(isset($model->taxonomicelement->family->family))
            return CHtml::encode($model->taxonomicelement->family->family)." <font style=\"font-size:11px;color:gray;\">(family)</font>";

        return false;
    }
}
?>
