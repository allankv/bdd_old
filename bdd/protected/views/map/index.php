<?php
$cs=Yii::app()->clientScript;
//Light box
$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_BEGIN);
$cs->registerCssFile("css/lightbox.css");
$cs->registerScriptFile("js/lightbox/recordlevelelements.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/loadfields.js",CClientScript::POS_HEAD);

$cs->registerScriptFile("js/recordlevelelements.js",CClientScript::POS_END);        
?>


<table style="width:60%;margin:15px;margin-top:30px;margin-left:auto;margin-right:auto;">
    <tr>
        <td style="width:60px;text-align:center;"><?php echo CHtml::image("images/help/iconelist.png"); ?></td>
        <td style="width:auto;vertical-align:middle;"><h1><?php echo Yii::t('yii', 'Draw specimen records on map'); ?></h1></td>
    </tr>
</table>

<?php echo CHtml::beginForm(); ?>

<div class="yiiForm">
    <table cellspacing="0" cellpadding="0" align="center" class="tablelist">
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Institution code'), "recordlevelelements",""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=institutioncode',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?>
            </td>
            <td class="tablefieldcel">
                <?php
                if($recordlevelelements->idinstitutioncode!="") {
                    echo CHtml::activeDropDownList($recordlevelelements, 'idinstitutioncode', CHtml::listData(institutioncodes::model()->findAll(" 1=1 ORDER BY institutioncode "), 'idinstitutioncode', 'institutioncode'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('recordlevelelements_idcollectioncode')"));
                }else {
                    echo CHtml::activeDropDownList($recordlevelelements, 'idinstitutioncode', CHtml::listData(institutioncodes::model()->findAll(" 1=1 ORDER BY institutioncode "), 'idinstitutioncode', 'institutioncode'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('recordlevelelements_idcollectioncode')"));
                }
                ?>
            </td>
            <td class="tableundocel">
                <div  style="display: none" ID='div-recordlevelelements_idinstitutioncodeUndo' >
                    <a HREF="javascript:habilitaDropDownList('recordlevelelements_idinstitutioncode','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Collection code'), "recordlevelelements",""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collectioncode',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeDropDownList($recordlevelelements, 'idcollectioncode', CHtml::listData(collectioncodes::model()->findAll(" 1=1 ORDER BY collectioncode "), 'idcollectioncode', 'collectioncode'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('taxonomicelements_idscientificname')")); ?>
            </td>
            <td class="tableundocel">
                <div  style="<?php if(($recordlevelelements->idcollectioncode!="")&&($taxonomicelements->scientificname=="")&&($occurrenceelements->catalognumber=="")) echo "display:block"; else echo "display:none";?>" ID='div-recordlevelelements_idcollectioncodeUndo' >
                    <a HREF="javascript:habilitaDropDownList('recordlevelelements_idcollectioncode','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii', 'Scientific name'), "taxonomicelements",""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificname',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?>
            </td>
            <td class="tablefieldcel">
            	<?php 
            	
            	if(($recordlevelelements->idcollectioncode!="")&&($taxonomicelements->scientificname=="")&&($occurrenceelements->catalognumber=="")){
            
                	echo CHtml::activeDropDownList($taxonomicelements, 'idscientificname', CHtml::listData(scientificnames::model()->findAll(" 1=1 ORDER BY scientificname "), 'idscientificname', 'scientificname'), array('empty'=>'-','onChange'=>"requisitaValoresDropDownList('occurrenceelements_catalognumber')")); 
                	
                    ?>
					<script >
                    $(document).ready(function(){
                        requisitaValoresDropDownList("taxonomicelements_idscientificname");
                    })
                	</script>

                    <?php                   	
                	
            	}else{
            	
            		echo CHtml::activeDropDownList($taxonomicelements, 'idscientificname', CHtml::listData(scientificnames::model()->findAll(" 1=1 ORDER BY scientificname "), 'idscientificname', 'scientificname'), array('empty'=>'-','disabled'=>'','onChange'=>"requisitaValoresDropDownList('occurrenceelements_catalognumber')"));
            		
            	}
                ?>
            </td>
            <td class="tableundocel">
                <div  style="<?php if(($taxonomicelements->scientificname!="")&&($occurrenceelements->catalognumber=="")) echo "display:block"; else echo "display:none";?>" ID='div-taxonomicelements_idscientificnameUndo' >
                    <a HREF="javascript:habilitaDropDownList('taxonomicelements_idscientificname','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                </div>
            </td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Catalog number'), "occurrenceelements",""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=catalognumber',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?>
            </td>
            <td class="tablefieldcel">
                <?php
                if(($occurrenceelements->catalognumber=="")&&($taxonomicelements->scientificname!="")) {
                    echo CHtml::activeDropDownList($occurrenceelements, 'catalognumber', CHtml::listData(occurrenceelements::model()->findAll(" 1=1 ORDER BY catalognumber "), 'catalognumber', 'catalognumber'), array('empty'=>'-','onChange'=>"exibeRespostaBusca('map')"));
                    ?>
                <script >
                    $(document).ready(function(){
                        requisitaValoresDropDownList("occurrenceelements_catalognumber");
                    })
                </script>
                    <?php
                }else {
                    echo CHtml::activeDropDownList($occurrenceelements, 'catalognumber', CHtml::listData(occurrenceelements::model()->findAll(" 1=1 ORDER BY catalognumber "), 'catalognumber', 'catalognumber'), array('empty'=>'-','disabled'=>'','onChange'=>"exibeRespostaBusca('map')"));
                }
                ?>
            </td>
            <td class="tableundocel">
                <div  style="<?php if($occurrenceelements->catalognumber!="") echo "display:block"; else echo "display:none";?>" ID='div-occurrenceelements_catalognumberUndo' >
                    <a HREF="javascript:habilitaDropDownList('occurrenceelements_catalognumber','')" ><?php echo Yii::t('yii','Undo'); ?></a>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding-top:15px;text-align:right;">
                <div style="margin-left: auto;margin-right: auto;text-align:right;">
                    <?php
                    if(($occurrenceelements->catalognumber=="")&&($taxonomicelements->scientificname!="")) {
                        echo CHtml::submitButton(Yii::t('yii','Search'), array('onclick'=>"exibeRespostaBusca('map');",'id'=>'botaoSearch'));
                    }else {
                        echo CHtml::submitButton(Yii::t('yii','Search'), array('onclick'=>"exibeRespostaBusca('map');",'disabled'=>'','id'=>'botaoSearch'));
                    }
                    ?>
                </div>
            </td>
        </tr>
        <?php echo CHtml::endForm(); ?>
    </table>

    <br/><br/>

    <?php if($recordlevelelementsListMap !== null) {
        $count_recordlevelelementsList = count($recordlevelelementsListMap);
        //var_dump($recordlevelelementsListMap);
        ?>
    <div style="vertical-align:middle;padding:10px;padding-left:20px;width:78%;letter-spacing:2px;margin-left:auto;margin-right:auto;background-color:#eeeeee;margin-bottom:5px;">
            <?php echo Yii::t('yii','Records found').": <font style=\"font-size:14px;font-weight:bold;\">".$count_recordlevelelementsList."</font>"; ?>
    </div>

    <div class="yiiForm" style="width:100%;padding:0px;margin:20px;margin-left:auto;margin-right:auto;background-color:red;">
        <!--Show Map-->
        <script type="text/javascript">
    <?php echo $arrayOfCoordinates; ?>
    <?php echo $arrayOfContentWindow; ?>
        </script>
            <?php $this->widget('MapEngine');?>
    </div>
        <?php } ?>

</div>