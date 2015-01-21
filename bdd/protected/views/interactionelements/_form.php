<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/interaction.js",CClientScript::POS_END);   
?>

<?php echo CHtml::beginForm(); ?>

<?php echo "<input TYPE='hidden' NAME='aux_idspecimens1' id='aux_idspecimens1' VALUE=".$interactionelements->getAttribute('idspecimens1')." > "; ?>
<?php echo "<input TYPE='hidden' NAME='aux_idspecimens2' id='aux_idspecimens2' VALUE=".$interactionelements->getAttribute('idspecimens2')." > "; ?>


<?php 

//Gerenciar mensagens de sucesso ou erro para o usuario 

if(!(isset($msgType))){

	if($_POST["msgType"]!="")
			$msgType = $_POST["msgType"];
		else
			$msgType = $_GET["msgType"];
	
}

switch($msgType){
	case "successDelete":
		echo "<div class='success'>";
		echo "<h2>".Yii::t('yii', 'Successfully deleted!')."</h2>";
		echo "</div>";
	break;
	
	case "successUpdate":
		echo "<div class='success'>";
		echo "<h2>".Yii::t('yii', 'Successfully updated!')."</h2>";
		echo "</div>";
	break;
}

?>


<!-- TEXTO INTRODUTORIO ----------------------------------------------->
<div style="width:80%;margin-top:30px;margin-left:auto;margin-right: auto;">
    <h1 style="margin:0px;"><?php echo Yii::t('yii','Create a new interaction record'); ?> </h1>
    <p class="tooltext"><?php echo Yii::t('yii','Use this tool to save information regarding the relationship between two occurrence records in the database. To expedite the process, use the search fields to find the specimen records whose interaction you wish to record and specify the Interaction type.'); ?></p>
</div>

<div style="margin-left:120px;">
<?php $this->widget('FieldsErrors',array('models'=>array($interactionelements))); ?>
<br>
</div>

<style type="text/css">
    <!--
    .int_label{
        width:210px;
        background-color:#f7f7f7;
        padding-top:5px;
        padding-left: 15px;
    }

    .int_undo{
        background-color:#f7f7f7;
        /*width:65px;*/
        text-align:center;
        vertical-align:bottom;
        padding-bottom:3px;
        text-align:left;
    }
    -->
</style>


<?php if(isset($idrecordlevelelement)) {?>

<div class="actionbar">
        <?php echo CHtml::link(CHtml::image("images/main/ico_seta2.gif", "",array("style"=>"border:0px;"))."&nbsp;&nbsp;".Yii::t('yii', "Go back to specimens list"),array('recordlevelelements/list','idinstitutioncode'=>$_GET['idinstitutioncode'], 'idcollectioncode'=>$_GET['idcollectioncode'], 'catalognumber'=>$_GET['catalognumber'], 'idscientificname'=>$_GET['idscientificname'], 'scientificnamevalue'=>$_GET['scientificnamevalue']));?>
</div>

<div style="
     background-color: #ebf4e9;
     padding:10px; padding-left:25px; padding-right:25px; width:75%;
     margin-left:auto; margin-right:auto; margin-top:10px; margin-bottom:30px;
     border: 1px solid #b4f4a6;text-align:center;">
    <h2 style="margin:0px;padding:0px;"><?php echo Yii::t('yii','Selected Specimen'); ?></h2>
    <p style="margin:0px;padding:0px;padding-top:10px;letter-spacing:2px;">
        [<?php echo CHtml::label(recordlevelelements::model()->findByPk($idrecordlevelelement)->basisofrecord->basisofrecord, "recordlevelelements");?>]
        [<?php echo CHtml::label(recordlevelelements::model()->findByPk($idrecordlevelelement)->institutioncode->institutioncode, "recordlevelelements");?>]
        [<?php echo CHtml::label(recordlevelelements::model()->findByPk($idrecordlevelelement)->collectioncode->collectioncode, "recordlevelelements");?>]
        [<b> <?php echo CHtml::label(recordlevelelements::model()->findByPk($idrecordlevelelement)->occurrenceelement->catalognumber, "recordlevelelements"); ?></b>]
    </p>
</div>

    <?php }?>

<?php
if(($inserindoNovamente)&&(!$update)) {
    //exibe o conteudo da interaction recem alterado
    echo $this->renderPartial('show',array('interactionelements'=>$interactionelements,
    'recordlevelelements'=>$recordlevelelements,
    'interactiontypes'=>$interactiontypes,
    'inserindoNovamente'=>$inserindoNovamente,
    ));
    echo "<br/>";
}
?>

<div class="yiiForm" style="width:80%;">

    <!-- Specimen 1 -->
    <div class="tablerequired" style="width:98%;padding:8px;margin-bottom:5px;letter-spacing:1.5px;font-weight:bold;font-size:12px;text-indent:7px;">
        <?php echo CHtml::encode(Yii::t('yii','Specimen')); ?> 1
    </div>

    <!--Mostrado apenas no update ou ao inserir um novo registro-->
    <div id='divSpecimenSelecionada1' class='change' style='display:<?php  if((($update)||($inserindoNovamente))||($recordlevelelementSpecimen1)) echo "block;"; else echo "none;";  ?>'>
        <?php        
            echo "
            <table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" style=\"background-color:transparent;\">
                <tr>";                 
                    
            		//mostra a opcao de mudar apenas se o especime for diferente daquele selcionado da listagem
            
      			    if((($update)||($inserindoNovamente))&&($recordlevelelementSpecimen1->idrecordlevelelements<>$idrecordlevelelement)) {
      			    
	            		echo "
	            		<td rowspan=\"2\" style=\"font-weight:bold;width:100px;text-align:left;\">
	            			<a href=\"javascript:ativaFiltrosSpecimen(1);\">".CHtml::image("images/main/edit.png", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Update')))."</a>
	                    	<a href=\"javascript:ativaFiltrosSpecimen(1);\">".Yii::t('yii',"Change")."</a>
	            		</td>";
            		
            		}
            		
                   echo "
                    <td style=\"width:110px;font-size:8pt;color:#888888;font-style: italic;\">".Yii::t('yii',"Institution")."</td>
                    <td style=\"width:110px;font-size:8pt;color:#888888;font-style: italic;\">".Yii::t('yii',"Collection")."</td>
                    <td style=\"width:100px;font-size:8pt;color:#888888;font-style: italic;\">".Yii::t('yii',"Catalog Number")."</td>
                    <td style=\"width:200px;font-size:8pt;color:#888888;font-style: italic;\">".Yii::t('yii',"Taxonomic Element")."</td>
                </tr>
                <tr>
                    <td>".CHtml::encode($recordlevelelementSpecimen1->institutioncode->institutioncode)."</td>
                    <td>".CHtml::encode($recordlevelelementSpecimen1->collectioncode->collectioncode)."</td>
                    <td>".CHtml::encode($recordlevelelementSpecimen1->occurrenceelement->catalognumber)."</td>
                    <td>".WebbeeController::lastTaxa($recordlevelelementSpecimen1)."</td>
                </tr>
            </table>";
        ?>
        <input TYPE='hidden' id='interactionelements_idspecimens1' NAME='interactionelements[idspecimens1]' VALUE=<?php echo $recordlevelelementSpecimen1->idrecordlevelelements; ?> >
    </div>

    <!--Mostrado apenas no update ou ao inserir um novo registro-->
    <div id='divFiltros1'  style='display:<?php  if(($update)||($recordlevelelementSpecimen1)) echo "none;"; else echo "block;";  ?>'>
        <?php if((($update)||($inserindoNovamente))) { ?>
        <div style="width:30%;margin-right:0px;" class="boxclean">
            <a href="javascript:desativaFiltrosSpecimen(1)" >
                    <?php echo CHtml::image("images/main/ico_seta2.gif", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Back')));
                    echo "&nbsp;&nbsp;".Yii::t('yii',"Cancel change");?></a>
        </div>
            <?php } ?>

        <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable" style="background-color:#f7f7f7;">
            <tr>
                <td style="vertical-align:top;">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="int_label">
                                <?php echo CHtml::label(Yii::t('yii',"Institution code"),'institutionCode1'); ?><br/>

                                <?php if($institutioncode1!="") {
                                    echo CHtml::dropDownList('institutionCode1',$institutioncode1,CHtml::listData(institutioncodes::model()->findAll(" 1=1 ORDER BY institutioncode "), 'idinstitutioncode', 'institutioncode'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('collectionCode','1')"));
                                }else {
                                    echo CHtml::dropDownList('institutionCode1',$institutioncode1,CHtml::listData(institutioncodes::model()->findAll(" 1=1 ORDER BY institutioncode "), 'idinstitutioncode', 'institutioncode'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('collectionCode','1')"));
                                }
                                ?>
                            </td>
                            <td class="int_undo">

                                <div  style="<?php if(($collectioncode1=="")&&($scientificname1=="")&&($basisofrecord1=="")&&($institutioncode1!="")) echo "display:block"; else echo "display:none";?>" id='div-institutionCode1Undo' >
                                    <a href="javascript:habilitaDropDownList('institutionCode',1)" ><?php echo Yii::t('yii',"Undo"); ?></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="int_label">
                                <?php echo CHtml::label(Yii::t('yii',"Collection code"),'collectionCode1'); ?>
                                <?php //echo CHtml::dropDownList('collectionCode1',$collectioncode1,CHtml::listData(collectioncodes::model()->findAll(" 1=1 ORDER BY collectioncode "), 'idcollectioncode', 'collectioncode'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('basisOfRecord',1)"));?>

                                <?php
                                if(($basisofrecord1=="")&&($scientificname1=="")&&($collectioncode1=="")&&($institutioncode1!="")) {
                                    echo CHtml::dropDownList('collectionCode1',$collectioncode1,CHtml::listData(collectioncodes::model()->findAll(" 1=1 ORDER BY collectioncode "), 'idcollectioncode', 'collectioncode'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('basisOfRecord','1')"));
                                    ?>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        requisitaValoresDropDownList("collectionCode","1");
                                    })
                                </script>
                                    <?php
                                }else {
                                    echo CHtml::dropDownList('collectionCode1',$collectioncode1,CHtml::listData(collectioncodes::model()->findAll(" 1=1 ORDER BY collectioncode "), 'idcollectioncode', 'collectioncode'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('basisOfRecord','1')"));
                                }
                                ?>

                            </td>
                            <td class="int_undo">
                                <div  style="<?php if(($collectioncode1!="")&&($scientificname1=="")&&($basisofrecord1=="")&&($institutioncode1!="")) echo "display:inline"; else echo "display:none";?>" id='div-collectionCode1Undo' >
                                    <a href="javascript:habilitaDropDownList('collectionCode',1)" ><?php echo Yii::t('yii',"Undo"); ?></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="int_label">
                                <?php echo CHtml::label(Yii::t('yii',"Basis of record"),'basisOfRecord1'); ?>
                                <?php //echo CHtml::dropDownList('basisOfRecord1',$basisofrecord1,CHtml::listData(basisofrecords::model()->findAll(" 1=1 ORDER BY basisofrecord "), 'idbasisofrecord', 'basisofrecord'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('scientificName',1)"));?>

                                <?php
                                if(($basisofrecord1=="")&&($scientificname1=="")&&($collectioncode1!="")&&($institutioncode1!="")) {
                                    echo CHtml::dropDownList('basisOfRecord1',$basisofrecord1,CHtml::listData(basisofrecords::model()->findAll(" 1=1 ORDER BY basisofrecord "), 'idbasisofrecord', 'basisofrecord'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('scientificName','1')"));
                                    ?>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        requisitaValoresDropDownList("basisOfRecord","1");
                                    })
                                </script>
                                    <?php
                                }else {
                                    echo CHtml::dropDownList('basisOfRecord1',$basisofrecord1,CHtml::listData(basisofrecords::model()->findAll(" 1=1 ORDER BY basisofrecord "), 'idbasisofrecord', 'basisofrecord'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('scientificName','1')"));
                                }
                                ?>

                            </td>
                            <td class="int_undo">
                                <div  style="<?php if(($basisofrecord1!="")&&($scientificname1=="")&&($collectioncode1!="")&&($institutioncode1!="")) echo "display:inline"; else echo "display:none";?>" id='div-basisOfRecord1Undo' >
                                    <a href="javascript:habilitaDropDownList('basisOfRecord',1)" ><?php echo Yii::t('yii',"Undo"); ?></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="int_label">
                                <?php echo CHtml::label(Yii::t('yii',"Scientific name"),'scientificName1'); ?>
                                <?php //echo CHtml::dropDownList('scientificName1',$scientificname1,CHtml::listData(scientificnames::model()->findAll(" 1=1 ORDER BY scientificname "), 'idscientificname', 'scientificname'), array('empty'=>'-','disabled'=>'','onChange'=>"realizaBusca(1,'".Yii::t('yii',"Please, select the required fields for filtering.")."')"));?>

                                <?php
                                if(($basisofrecord1!="")&&($scientificname1=="")&&($collectioncode1!="")&&($institutioncode1!="")) {
                                    echo CHtml::dropDownList('scientificName1',$scientificname1,CHtml::listData(scientificnames::model()->findAll(" 1=1 ORDER BY scientificname "), 'idscientificname', 'scientificname'), array('empty'=>'-','onChange'=>"realizaBusca(1,'".Yii::t('yii',"Please, select the required fields for filtering.")."')"));
                                    ?>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        requisitaValoresDropDownList("scientificName","1");
                                    })
                                </script>
                                    <?php
                                }else {
                                    echo CHtml::dropDownList('scientificName1',$scientificname1,CHtml::listData(scientificnames::model()->findAll(" 1=1 ORDER BY scientificname "), 'idscientificname', 'scientificname'), array('empty'=>'-','disabled'=>'','onChange'=>"realizaBusca(1,'".Yii::t('yii',"Please, select the required fields for filtering.")."')"));
                                }
                                ?>

                            </td>
                            <td class="int_undo">
                                <div  style="<?php if(($scientificname1!="")&&($basisofrecord1!="")&&($collectioncode1!="")&&($institutioncode1!="")) echo "display:inline"; else echo "display:none";?>" id='div-scientificName1Undo' >
                                    <a href="javascript:habilitaDropDownList('scientificName',1)" ><?php echo Yii::t('yii',"Undo"); ?></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;text-align:right;background-color:#f7f7f7;">
                                <?php
                                echo CHtml::button(Yii::t('yii','Search'), array("onclick"=>"realizaBusca(1,'".Yii::t('yii',"Please, select the required fields for filtering.")."');",'disabled'=>'','id'=>'botaoSearch1'));

                                if(($collectioncode1!="")&&($institutioncode1!="")) {

                                    ?>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        realizaBusca(1,'<?php echo Yii::t('yii',"Please, select the required fields for filtering.");?>' );
                                    })
                                </script>
                                    <?php
                                }
                                ?>
                            </td>
                            <td style="background-color:#f7f7f7;"></td>
                        </tr>
                    </table>
                </td>
                <td style="width:430px;background-color:#f0f0f0;vertical-align:top;-moz-border-radius-topleft: 1em;-moz-border-radius-topright: 1em;-moz-border-radius-bottomleft: 1em;-moz-border-radius-bottomright: 1em;border:1px solid #f3f3f3;">
                    <div id="dividspecimens1" ></div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id='divErro1' class="erroInteracao"  style="width: 100%;text-align: center;" ></div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Intraction -->
    <div class="tablerequired" style="margin-top:15px;margin-bottom:5px;width:98%;padding:8px;letter-spacing:1.5px;font-weight:bold;font-size:12px;text-indent:7px;">
        <?php echo CHtml::encode(Yii::t('yii','Interaction')); ?>
    </div>

    <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable" style="margin-top:0px;margin-bottom:15px;padding:15px;background-color:#f8f8f8;-moz-border-radius-topleft: 0.4em;-moz-border-radius-topright: 0.4em;-moz-border-radius-bottomleft: 0.4em;-moz-border-radius-bottomright: 0.4em;border:1px solid #f3f3f3;">
        <tr>
            <td style="vertical-align:top;width:280px;">
                <?php echo CHtml::label(Yii::t('yii',"Interaction type"),'idinteractiontype'); ?><span class="required">*</span><br/>
                <?php echo CHtml::activeDropDownList($interactionelements, 'idinteractiontype', CHtml::listData(interactiontypes::model()->findAll(), 'idinteractiontype', 'interactiontype'), array('empty'=>'-'));?>
            </td>
            <td style="vertical-align:top;">
                <?php echo CHtml::label(Yii::t('yii',"Related information"),'interactionrelatedinformation'); ?><br/>
                <?php echo CHtml::activeTextArea($interactionelements,'interactionrelatedinformation',array('rows'=>8, 'cols'=>150,'style'=>'width:350px;height:60px;')); ?>
            </td>
        </tr>
    </table>

    <!-- Specimen 2 -->
    <div class="tablerequired" style="width:98%;padding:8px;margin-bottom:5px;letter-spacing:1.5px;font-weight:bold;font-size:12px;text-indent:7px;">
        <?php echo CHtml::encode(Yii::t('yii','Specimen')); ?> 2
    </div>

    <!--Mostrado apenas no update ou ao inserir um novo registro-->
    <div id='divSpecimenSelecionada2' class='change' style='display:<?php  if((($update)||($inserindoNovamente))) echo "block;"; else echo "none;";  ?>'  >
        <?php
            echo "
            <table cellpadding=\"0\" cellspacing=\"0\" align=\"center\" style=\"background-color:transparent;\">
                <tr>";                 
                    
            		//mostra a opcao de mudar apenas se o especime for diferente daquele selcionado da listagem
            
      			    if((($update)||($inserindoNovamente))&&($recordlevelelementSpecimen2->idrecordlevelelements<>$idrecordlevelelement)) {
      			    
	            		echo "
	            		<td rowspan=\"2\" style=\"font-weight:bold;width:100px;text-align:left;\">
	            			<a href=\"javascript:ativaFiltrosSpecimen(2);\">".CHtml::image("images/main/edit.png", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Update')))."</a>
	                    	<a href=\"javascript:ativaFiltrosSpecimen(2);\">".Yii::t('yii',"Change")."</a>
	            		</td>";
            		
            		}
            		
                   echo "
                    <td style=\"width:110px;font-size:8pt;color:#888888;font-style: italic;\">".Yii::t('yii',"Institution")."</td>
                    <td style=\"width:110px;font-size:8pt;color:#888888;font-style: italic;\">".Yii::t('yii',"Collection")."</td>
                    <td style=\"width:100px;font-size:8pt;color:#888888;font-style: italic;\">".Yii::t('yii',"Catalog Number")."</td>
                    <td style=\"width:200px;font-size:8pt;color:#888888;font-style: italic;\">".Yii::t('yii',"Taxonomic Element")."</td>
                </tr>
                <tr>
                    <td>".CHtml::encode($recordlevelelementSpecimen2->institutioncode->institutioncode)."</td>
                    <td>".CHtml::encode($recordlevelelementSpecimen2->collectioncode->collectioncode)."</td>
                    <td>".CHtml::encode($recordlevelelementSpecimen2->occurrenceelement->catalognumber)."</td>
                    <td>".WebbeeController::lastTaxa($recordlevelelementSpecimen2)."</td>
                </tr>
            </table>";
        ?>
        <input TYPE='hidden' id='interactionelements_idspecimens2' NAME='interactionelements[idspecimens2]' VALUE=<?php echo $recordlevelelementSpecimen2->idrecordlevelelements; ?> >
    </div>

    <!--Mostrado quando inserir um novo-->
    <div id='divFiltros2'  style='display:<?php  if((($update)||($inserindoNovamente))) echo "none;"; else echo "block;";  ?>'>
        <!--Mostrado apenas no update ou ao inserir um novo registro-->
        <?php if((($update)||($inserindoNovamente))) { ?>
        <div style="width:30%;margin-right:0px;" class="boxclean">
            <a href="javascript:desativaFiltrosSpecimen(2)" >
                    <?php echo CHtml::image("images/main/ico_seta2.gif", "",array("style"=>"border:0px;", "title"=>Yii::t('yii','Back')));
                    echo "&nbsp;&nbsp;".Yii::t('yii',"Cancel change");?></a>
        </div>
            <?php } ?>

        <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable" style="background-color:#f7f7f7;">
            <tr>
                <td style="vertical-align:top;">

                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="int_label">
                                <?php echo CHtml::label(Yii::t('yii',"Institution code"),'institutionCode2'); ?>

                                <?php if($institutioncode2!="") {
                                    echo CHtml::dropDownList('institutionCode2',$institutioncode2,CHtml::listData(institutioncodes::model()->findAll(" 1=1 ORDER BY institutioncode "), 'idinstitutioncode', 'institutioncode'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('collectionCode','2')"));
                                }else {
                                    echo CHtml::dropDownList('institutionCode2',$institutioncode2,CHtml::listData(institutioncodes::model()->findAll(" 1=1 ORDER BY institutioncode "), 'idinstitutioncode', 'institutioncode'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('collectionCode','2')"));
                                }
                                ?>

                            </td>
                            <td class="int_undo">
                                <div  style="<?php if(($collectioncode2=="")&&($scientificname2=="")&&($basisofrecord2=="")&&($institutioncode2!="")) echo "display:block"; else echo "display:none";?>" id='div-institutionCode2Undo' >
                                    <a href="javascript:habilitaDropDownList('institutionCode',2)" ><?php echo Yii::t('yii',"Undo"); ?></a>
                                </div>
                            </td>
                        </tr>
    <!--                <td rowspan="4" align="center" valign="middle" >
						<a href="javascript:realizaBusca(2,'<?php //echo Yii::t('yii',"Please, select the required fields for filtering."); ?>');" ><?php echo Yii::t('yii',"Search"); ?></a>
				</td>-->
                        <tr>
                            <td class="int_label">
                                <?php echo CHtml::label(Yii::t('yii',"Collection code"),'collectionCode2'); ?>
                                <?php //echo CHtml::dropDownList('collectionCode2',$collectioncode2,CHtml::listData(collectioncodes::model()->findAll(" 1=1 ORDER BY collectioncode "), 'idcollectioncode', 'collectioncode'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('basisOfRecord',2)"));?>

                                <?php
                                if(($basisofrecord2=="")&&($scientificname2=="")&&($collectioncode2=="")&&($institutioncode2!="")) {
                                    echo CHtml::dropDownList('collectionCode2',$collectioncode2,CHtml::listData(collectioncodes::model()->findAll(" 1=1 ORDER BY collectioncode "), 'idcollectioncode', 'collectioncode'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('basisOfRecord','2')"));
                                    ?>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        requisitaValoresDropDownList("collectionCode","2");
                                    })
                                </script>
                                    <?php
                                }else {
                                    echo CHtml::dropDownList('collectionCode2',$collectioncode2,CHtml::listData(collectioncodes::model()->findAll(" 1=1 ORDER BY collectioncode "), 'idcollectioncode', 'collectioncode'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('basisOfRecord','2')"));
                                }
                                ?>

                            </td>
                            <td class="int_undo">
                                <div  style="<?php if(($collectioncode2!="")&&($scientificname2=="")&&($basisofrecord2=="")&&($institutioncode2!="")) echo "display:inline"; else echo "display:none";?>" id='div-collectionCode2Undo' >
                                    <a href="javascript:habilitaDropDownList('collectionCode',2)" ><?php echo Yii::t('yii',"Undo"); ?></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="int_label">
                                <?php echo CHtml::label(Yii::t('yii',"Basis of record"),'basisOfRecord2'); ?>
                                <?php //echo CHtml::dropDownList('basisOfRecord2',$basisofrecord2,CHtml::listData(basisofrecords::model()->findAll(" 1=1 ORDER BY basisofrecord "), 'idbasisofrecord', 'basisofrecord'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('scientificName',2)"));?>


                                <?php
                                if(($basisofrecord2=="")&&($scientificname2=="")&&($collectioncode2!="")&&($institutioncode2!="")) {
                                    echo CHtml::dropDownList('basisOfRecord2',$basisofrecord2,CHtml::listData(basisofrecords::model()->findAll(" 1=1 ORDER BY basisofrecord "), 'idbasisofrecord', 'basisofrecord'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('scientificName','2')"));
                                    ?>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        requisitaValoresDropDownList("basisOfRecord","2");
                                    })
                                </script>
                                    <?php
                                }else {
                                    echo CHtml::dropDownList('basisOfRecord2',$basisofrecord2,CHtml::listData(basisofrecords::model()->findAll(" 1=1 ORDER BY basisofrecord "), 'idbasisofrecord', 'basisofrecord'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('scientificName','2')"));
                                }
                                ?>


                            </td>
                            <td class="int_undo">
                                <div  style="<?php if(($basisofrecord2!="")&&($scientificname2=="")&&($collectioncode2!="")&&($institutioncode2!="")) echo "display:inline"; else echo "display:none";?>" id='div-basisOfRecord2Undo' >
                                    <a href="javascript:habilitaDropDownList('basisOfRecord',2)" ><?php echo Yii::t('yii',"Undo"); ?></a>
                                </div>
                            </td>
                        </tr>                        
                        <tr>
                            <td class="int_label">
                                <?php echo CHtml::label(Yii::t('yii',"Scientific name"),'scientificName2'); ?>
                                <?php //echo CHtml::dropDownList('scientificName2',$scientificname2,CHtml::listData(scientificnames::model()->findAll(" 1=1 ORDER BY scientificname "), 'idscientificname', 'scientificname'), array('empty'=>'-','disabled'=>'','onChange'=>"realizaBusca(2,'".Yii::t('yii',"Please, select the required fields for filtering.")."')"));?>


                                <?php
                                if(($basisofrecord2!="")&&($scientificname2=="")&&($collectioncode2!="")&&($institutioncode2!="")) {
                                    echo CHtml::dropDownList('scientificName2',$scientificname2,CHtml::listData(scientificnames::model()->findAll(" 1=1 ORDER BY scientificname "), 'idscientificname', 'scientificname'), array('empty'=>'-','onChange'=>"realizaBusca(2,'".Yii::t('yii',"Please, select the required fields for filtering.")."')"));
                                    ?>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        requisitaValoresDropDownList("scientificName","2");
                                    })
                                </script>
                                    <?php
                                }else {
                                    echo CHtml::dropDownList('scientificName2',$scientificname2,CHtml::listData(scientificnames::model()->findAll(" 1=1 ORDER BY scientificname "), 'idscientificname', 'scientificname'), array('empty'=>'-','disabled'=>'','onChange'=>"realizaBusca(2,'".Yii::t('yii',"Please, select the required fields for filtering.")."')"));
                                }
                                ?>

                            </td>
                            <td class="int_undo">
                                <div  style="<?php if(($scientificname2!="")&&($basisofrecord2!="")&&($collectioncode2!="")&&($institutioncode2!="")) echo "display:inline"; else echo "display:none";?>" id='div-scientificName2Undo' >
                                    <a href="javascript:habilitaDropDownList('scientificName',2)" ><?php echo Yii::t('yii',"Undo"); ?></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px;text-align:right;background-color:#f7f7f7;">
                                <?php
                                echo CHtml::button(Yii::t('yii','Search'), array("onclick"=>"realizaBusca(2,'".Yii::t('yii',"Please, select the required fields for filtering.")."');",'disabled'=>'','id'=>'botaoSearch2'));

                                if(($collectioncode2!="")&&($institutioncode2!="")) {

                                    ?>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        realizaBusca(2,'<?php echo Yii::t('yii',"Please, select the required fields for filtering.");?>' );
                                    })
                                </script>
                                    <?php
                                }

                                ?>
                            </td>
                            <td style="background-color:#f7f7f7;"></td>
                        </tr>
                    </table>
                </td>
                <td style="width:430px;background-color:#f0f0f0;vertical-align:top;-moz-border-radius-topleft: 1em;-moz-border-radius-topright: 1em;-moz-border-radius-bottomleft: 1em;-moz-border-radius-bottomright: 1em;border:1px solid #f3f3f3;">
                    <div id="dividspecimens2" ></div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="divErro2" class="erroInteracao" style="width: 100%;text-align: center;"></div>
                </td>
            </tr>
        </table>
    </div>

    <div class="privateRecord" style="margin-top:20px;">
        <?php echo CHtml::activeCheckBox($interactionelements, 'isrestricted')."&nbsp;&nbsp;".Yii::t('yii','Check here to make this record private')."&nbsp;&nbsp;".CHtml::image("images/main/private.gif", "",array("style"=>"border:0px;")); ?>
    </div>

    <div class="actionnew">
        <?php echo CHtml::button($update ? Yii::t('yii', "Save") : Yii::t('yii', "Insert"), array("style"=>"width:140px;font-size:9pt;font-family:verdana;","onclick"=>"submeterFormulario()")); ?>
        <?php //echo CHtml::submitButton($update ? Yii::t('yii', "Save") : Yii::t('yii', "Insert"), array("style"=>"width:140px;font-size:9pt;font-family:verdana;")); ?>
    </div>

</div>

<?php echo CHtml::endForm(); ?>


<?php
// Caso algum RecordLevelElement tenha sido selecionado anteriormente, exibe as interações relacionadas
if(isset($idrecordlevelelement)) {
    echo Yii::app()->controller->renderPartial('/interactionelements/list', array(
    'interactionelements'=>$interactionelements,
    'interactionelementsList'=>$interactionelementsList,
    'recordlevelelements'=>$recordlevelelements,
    'interactiontypes'=>$interactiontypes,
    'idrecordlevelelement'=>$idrecordlevelelement,
    'pages'=>$pages,
    'exibeControle'=>false,
    'totalRegistros'=>$totalRegistros,
    ));
}
?>
