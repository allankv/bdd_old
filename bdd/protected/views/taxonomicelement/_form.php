<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_HEAD);	
$cs->registerScriptFile("js/lightbox/taxonomicelements.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/taxonomicelements.js",CClientScript::POS_HEAD);
$cs->registerCssFile("css/lightbox.css");
?>

<?php if($showActionButton) echo CHtml::beginForm(); ?>
<?php if($showActionButton) echo CHtml::errorSummary($taxonomicelements); ?>

<div class="subgroup"><?php echo Yii::t('yii','Taxa'); ?></div>

<div style="display: none;" class="boxclean" id="divLimparTaxonomicElements"  >
    <a href="javascript:limparCamposTaxonomicElements()" >
        <?php echo CHtml::image("images/main/eraser.jpg", "",array("style"=>"border:0px;")); ?>&nbsp;
        <?php echo Yii::t('yii','Clean suggested items'); ?>
    </a>
</div>

<table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">

    <!--<div class="tablerow" id='divkingdom'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Kingdom'), "taxonomicelements");?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=kingdom',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idkingdom');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[kingdomvalue]', $autocompletehiddenfield['kingdomvalue'], array('id'=>'kingdomvalue'));?>
            <?php
            /*
                             *INPUT - Kingdom com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$kingdoms->kingdom,
                    'name'=>'q',
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15,
                    'minChars'=>2,
                    'delay'=>500,
                    'matchCase'=>false,
                    'id'=>'kingdom',
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".setOptions({extraParams : {
                                                'formIdPhylum': function(){return \$(\"#taxonomicelements_idphylum\").val();},
                                                'formIdClass': function(){return \$(\"#taxonomicelements_idclass\").val();},
                                                'formIdOrder': function(){return \$(\"#taxonomicelements_idorder\").val();},
                                                'formIdFamily': function(){return \$(\"#taxonomicelements_idfamily\").val();},
                                                'formIdGenus': function(){return \$(\"#taxonomicelements_idgenus\").val();},
                                                'formIdSubgenus': function(){return \$(\"#taxonomicelements_idsubgenus\").val();},
                                                'formIdSpecificEpithet': function(){return \$(\"#taxonomicelements_idspecificepithet\").val();},
                                                'formIdInfraSpecificepithet': function(){return \$(\"#taxonomicelements_idinfraspecificepithet\").val();},
                                                'formIdScientificName': function(){return \$(\"#taxonomicelements_idscientificname\").val();},
                                                'formIdSpecificRank': function(){return \$(\"#taxonomicelements_idspecificrank\").val();},
                                                'formIdScientificNameAuthorship': function(){return \$(\"#taxonomicelements_idscientificnameauthorship\").val();},
                                                'formIdNomenclaturalCode': function(){return \$(\"#taxonomicelements_idnomenclaturalcode\").val();},
                                                'tableField':'kingdom'
                                          } }).result(function(event,item){
                                                $(\"#taxonomicelements_idkingdom\").val(item[1]);
                                                $('#kingdomvalue').val(item[0]);

                                                escondeBotaoResetTaxonomicElements();
                                                        var camposReset = new Array();
                                                        camposReset.push(0);

//                                                            \$(\"#divkingdomReset\").css(\"display\",\"block\");
//
//                                                                    if (item[0]!=''){
//                                                                            dasabilitaCampos(\"kingdom\");
//                                                                            \$('#divkingdomValor').text(item[0]);
//                                                                    }else
//                                                                            habilitaCampos(\"kingdom\");

                                                camposReset.push(\"kingdom\");
                                                camposPreenchidosTaxonomicElements.push(camposReset);

                                                habilitaLinkDesfazerTaxonomicElements()
                                                
                                          });",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=kingdoms/list" onclick="this.href = 'index.php?r=kingdoms/list' + concatenarValoresUrlTaxonomicElements()" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=kingdoms/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divkingdomLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idkingdom');
    echo CHtml::label(Yii::t('yii','Kingdom'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divkingdomValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divkingdomReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divphylum'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Phylum'), "taxonomicelements");?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=phylum',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idphylum');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[phylumvalue]', $autocompletehiddenfield['phylumvalue'], array('id'=>'phylumvalue'));?>
            <?php
            /*
                             *INPUT - Phylum com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$phylums->phylum,
                    'name'=>'q',
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15,
                    'minChars'=>2,
                    'delay'=>500,
                    'matchCase'=>false,
                    'id'=>'phylum',
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".setOptions({extraParams : {
                                                    'formIdKingdom': function(){return \$(\"#taxonomicelements_idkingdom\").val();},
                                                    'formIdClass': function(){return \$(\"#taxonomicelements_idclass\").val();},
                                                    'formIdOrder': function(){return \$(\"#taxonomicelements_idorder\").val();},
                                                    'formIdFamily': function(){return \$(\"#taxonomicelements_idfamily\").val();},
                                                    'formIdGenus': function(){return \$(\"#taxonomicelements_idgenus\").val();},
                                                    'formIdSubgenus': function(){return \$(\"#taxonomicelements_idsubgenus\").val();},
                                                    'formIdSpecificEpithet': function(){return \$(\"#taxonomicelements_idspecificepithet\").val();},
                                                    'formIdInfraSpecificepithet': function(){return \$(\"#taxonomicelements_idinfraspecificepithet\").val();},
                                                    'formIdScientificName': function(){return \$(\"#taxonomicelements_idscientificname\").val();},
                                                    'formIdSpecificRank': function(){return \$(\"#taxonomicelements_idspecificrank\").val();},
                                                    'formIdScientificNameAuthorship': function(){return \$(\"#taxonomicelements_idscientificnameauthorship\").val();},
                                                    'formIdNomenclaturalCode': function(){return \$(\"#taxonomicelements_idnomenclaturalcode\").val();},
                                                    'tableField':'phylum'
                                                    } }).result(function(event,item){

                                                            \$(\"#taxonomicelements_idphylum\").val(item[1]);
                                                            $('#phylumvalue').val(item[0]);

                                                            escondeBotaoResetTaxonomicElements();
                                                                    var camposReset = new Array();
                                                                    camposReset.push(0);

//                                                            \$(\"#divphylumReset\").css(\"display\",\"block\");

                                                              if(\$(\"#kingdom\").val()==''){
                                                                    camposReset.push(\"kingdom\");
                                                              }

                                                            \$(\"#kingdom\").val(item[2]);
                                                            $('#kingdomvalue').val(item[2]);
                                                            \$(\"#taxonomicelements_idkingdom\").val(item[3]);

//                                                                    if (item[2]!=''){
//                                                                            dasabilitaCampos(\"kingdom\");
//                                                                            \$('#divkingdomValor').text(item[2]);
//                                                                    }else
//                                                                            habilitaCampos(\"kingdom\");
//
//                                                                    if (item[0]!=''){
//                                                                            dasabilitaCampos(\"phylum\");
//                                                                            $('#divphylumValor').text(item[0]);
//                                                                    }else
//                                                                            habilitaCampos(\"phylum\");

                                                            camposReset.push(\"phylum\");
                                                            camposPreenchidosTaxonomicElements.push(camposReset);

                                                            habilitaLinkDesfazerTaxonomicElements()
                                                            })",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=phylums/list" onclick="this.href = 'index.php?r=phylums/list' + concatenarValoresUrlTaxonomicElements()"  rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=phylums/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divphylumLabel' style='display: none;'>
            <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
                <tr>
                    <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idphylum');
    echo CHtml::label(Yii::t('yii','Phylum'), "taxonomicelements");
    ?>
                    </td>
                    <td style="width: 272px;">
                        <span class="simple" id='divphylumValor' ></span>
                    </td>
                    <td>
                        <span class="simple" id='divphylumReset' style='display:none;' >
                            <a href="#" onclick="limpaCamposTaxonomicElements()"   ><?php echo Yii::t('yii', "Undo");?></a></span>
                    </td>
                </tr>
            </table>
        </div>-->
    <!--<div class="tablerow" id='divclass'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Class'), "taxonomicelements");?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=class',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idclass');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[classvalue]', $autocompletehiddenfield['classvalue'], array('id'=>'classvalue'));?>
            <?php
            /*
                     *INPUT - Class com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$classes->class,
                    'name'=>'q',
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15,
                    'minChars'=>2,
                    'delay'=>500,
                    'matchCase'=>false,
                    'id'=>'class',
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".setOptions({extraParams : {
                                    'formIdKingdom': function(){return \$(\"#taxonomicelements_idkingdom\").val();},
                                            'formIdPhylum': function(){return \$(\"#taxonomicelements_idphylum\").val();},
                                            'formIdOrder': function(){return \$(\"#taxonomicelements_idorder\").val();},
                                            'formIdFamily': function(){return \$(\"#taxonomicelements_idfamily\").val();},
                                            'formIdGenus': function(){return \$(\"#taxonomicelements_idgenus\").val();},
                                            'formIdSubgenus': function(){return \$(\"#taxonomicelements_idsubgenus\").val();},
                                            'formIdSpecificEpithet': function(){return \$(\"#taxonomicelements_idspecificepithet\").val();},
                                            'formIdInfraSpecificepithet': function(){return \$(\"#taxonomicelements_idinfraspecificepithet\").val();},
                                            'formIdScientificName': function(){return \$(\"#taxonomicelements_idscientificname\").val();},
                                            'formIdSpecificRank': function(){return \$(\"#taxonomicelements_idspecificrank\").val();},
                                            'formIdScientificNameAuthorship': function(){return \$(\"#taxonomicelements_idscientificnameauthorship\").val();},
                                            'formIdNomenclaturalCode': function(){return \$(\"#taxonomicelements_idnomenclaturalcode\").val();},
                                            'tableField':'class'
                                            } }).result(function(event,item){
                                                    \$(\"#taxonomicelements_idclass\").val(item[1]);
                                                    $('#classvalue').val(item[0]);

                                                    escondeBotaoResetTaxonomicElements();
                                                            var camposReset = new Array();
                                                            camposReset.push(0);

//                                                    \$(\"#divclassReset\").css(\"display\",\"block\");

                                                    if(\$(\"#kingdom\").val()=='')
                                                            camposReset.push(\"kingdom\");

                                                    \$(\"#kingdom\").val(item[2]);
                                                    $('#kingdomvalue').val(item[2]);
                                                    \$(\"#taxonomicelements_idkingdom\").val(item[3]);


//                                                            if (item[2]!=''){
//                                                                    dasabilitaCampos(\"kingdom\");
//                                                                    \$('#divkingdomValor').text(item[2]);
//                                                            }else
//                                                                    habilitaCampos(\"kingdom\");


                                                    if(\$(\"#phylum\").val()=='')
                                                            camposReset.push(\"phylum\");

                                                    \$(\"#phylum\").val(item[4]);
                                                    $('#phylumvalue').val(item[4]);
                                                    \$(\"#taxonomicelements_idphylum\").val(item[5]);

//                                                            if (item[4]!=''){
//                                                                    dasabilitaCampos(\"phylum\");
//                                                                    $('#divphylumValor').text(item[4]);
//                                                            }else
//                                                                    habilitaCampos(\"phylum\");

//                                                    if (item[0]!=''){
//                                                            dasabilitaCampos(\"class\");
//                                                            $('#divclassValor').text(item[0]);
//                                                    }else
//                                                            habilitaCampos(\"class\");

                                                    camposReset.push(\"class\");
                                                    camposPreenchidosTaxonomicElements.push(camposReset);

                                                    habilitaLinkDesfazerTaxonomicElements()
                                                    })",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=classes/list" onclick="this.href = 'index.php?r=classes/list' + concatenarValoresUrlTaxonomicElements()"  rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=classes/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>

        </td>
    </tr>
    <!--<div class="simple" id='divclassLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idclass');
    echo CHtml::label(Yii::t('yii','Class'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divclassValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divclassReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divorder'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Order'), "taxonomicelements");?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=order',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idorder');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[ordervalue]', $autocompletehiddenfield['ordervalue'], array('id'=>'ordervalue'));?>
            <?php
            /*
                     *INPUT - Order com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$orders->order,
                    'name'=>'q',
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15,
                    'minChars'=>2,
                    'delay'=>500,
                    'matchCase'=>false,
                    'id'=>'order',
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".setOptions({extraParams : {
                                    'formIdKingdom': function(){return \$(\"#taxonomicelements_idkingdom\").val();},
                                            'formIdPhylum': function(){return \$(\"#taxonomicelements_idphylum\").val();},
                                            'formIdClass': function(){return \$(\"#taxonomicelements_idclass\").val();},
                                            'formIdFamily': function(){return \$(\"#taxonomicelements_idfamily\").val();},
                                            'formIdGenus': function(){return \$(\"#taxonomicelements_idgenus\").val();},
                                            'formIdSubgenus': function(){return \$(\"#taxonomicelements_idsubgenus\").val();},
                                            'formIdSpecificEpithet': function(){return \$(\"#taxonomicelements_idspecificepithet\").val();},
                                            'formIdInfraSpecificepithet': function(){return \$(\"#taxonomicelements_idinfraspecificepithet\").val();},
                                            'formIdScientificName': function(){return \$(\"#taxonomicelements_idscientificname\").val();},
                                            'formIdSpecificRank': function(){return \$(\"#taxonomicelements_idspecificrank\").val();},
                                            'formIdScientificNameAuthorship': function(){return \$(\"#taxonomicelements_idscientificnameauthorship\").val();},
                                            'formIdNomenclaturalCode': function(){return \$(\"#taxonomicelements_idnomenclaturalcode\").val();},
                                            'tableField':'order'
                                            } }).result(function(event,item){
                                                    \$(\"#taxonomicelements_idorder\").val(item[1]);
                                                    $('#ordervalue').val(item[0]);

                                                    escondeBotaoResetTaxonomicElements();
                                                            var camposReset = new Array();
                                                            camposReset.push(0);

//                                                    \$(\"#divorderReset\").css(\"display\",\"block\");

                                                    if(\$(\"#kingdom\").val()=='')
                                                            camposReset.push(\"kingdom\");

                                                    \$(\"#kingdom\").val(item[2]);
                                                    $('#kingdomvalue').val(item[2]);
                                                    \$(\"#taxonomicelements_idkingdom\").val(item[3]);

//                                                    if (item[2]!=''){
//                                                            dasabilitaCampos(\"kingdom\");
//                                                            $('#divkingdomValor').text(item[2]);
//                                                    }else
//                                                            habilitaCampos(\"kingdom\");

                                                    if(\$(\"#phylum\").val()=='')
                                                            camposReset.push(\"phylum\");

                                                    \$(\"#phylum\").val(item[4]);
                                                    $('#phylumvalue').val(item[4]);
                                                    \$(\"#taxonomicelements_idphylum\").val(item[5]);

//                                                    if (item[4]!=''){
//                                                            dasabilitaCampos(\"phylum\");
//                                                            $('#divphylumValor').text(item[4]);
//                                                    }else
//                                                            habilitaCampos(\"phylum\");

                                                    if(\$(\"#class\").val()=='')
                                                            camposReset.push(\"class\");

                                                    \$(\"#class\").val(item[6]);
                                                    $('#classvalue').val(item[6]);
                                                    \$(\"#taxonomicelements_idclass\").val(item[7]);

//                                                    if (item[6]!=''){
//                                                            //dasabilitaCampos(\"class\");
//                                                            //$('#divclassValor').text(item[6]);
//                                                    }else
//                                                            habilitaCampos(\"class\");
//
//                                                    if (item[0]!=''){
//                                                            dasabilitaCampos(\"order\");
//                                                            $('#divorderValor').text(item[0]);
//                                                    }else
//                                                            habilitaCampos(\"order\");

                                                    camposReset.push(\"order\");
                                                    camposPreenchidosTaxonomicElements.push(camposReset);

                                                    habilitaLinkDesfazerTaxonomicElements()
                                            })",
            ));

            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=orders/list" onclick="this.href = 'index.php?r=orders/list' + concatenarValoresUrlTaxonomicElements()"  rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=orders/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divorderLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idorder');
    echo CHtml::label(Yii::t('yii','Order'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divorderValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divorderReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divfamily'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Family'), "taxonomicelements");?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=family',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idfamily');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[familyvalue]', $autocompletehiddenfield['familyvalue'], array('id'=>'familyvalue'));?>
            <?php
            /*
                     *INPUT - Family com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$families->family,
                    'name'=>'q',
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15,
                    'minChars'=>2,
                    'delay'=>500,
                    'matchCase'=>false,
                    'id'=>'family',
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".setOptions({extraParams : {
                                    'formIdKingdom': function(){return \$(\"#taxonomicelements_idkingdom\").val();},
                                            'formIdPhylum': function(){return \$(\"#taxonomicelements_idphylum\").val();},
                                            'formIdClass': function(){return \$(\"#taxonomicelements_idclass\").val();},
                                            'formIdOrder': function(){return \$(\"#taxonomicelements_idorder\").val();},
                                            'formIdGenus': function(){return \$(\"#taxonomicelements_idgenus\").val();},
                                            'formIdSubgenus': function(){return \$(\"#taxonomicelements_idsubgenus\").val();},
                                            'formIdSpecificEpithet': function(){return \$(\"#taxonomicelements_idspecificepithet\").val();},
                                            'formIdInfraSpecificepithet': function(){return \$(\"#taxonomicelements_idinfraspecificepithet\").val();},
                                            'formIdScientificName': function(){return \$(\"#taxonomicelements_idscientificname\").val();},
                                            'formIdSpecificRank': function(){return \$(\"#taxonomicelements_idspecificrank\").val();},
                                            'formIdScientificNameAuthorship': function(){return \$(\"#taxonomicelements_idscientificnameauthorship\").val();},
                                            'formIdNomenclaturalCode': function(){return \$(\"#taxonomicelements_idnomenclaturalcode\").val();},
                                            'tableField':'family'
                                            } }).result(function(event,item){
                                                    \$(\"#taxonomicelements_idfamily\").val(item[1]);
                                                    $('#familyvalue').val(item[0]);

                                                    escondeBotaoResetTaxonomicElements();
                                                            var camposReset = new Array();
                                                            camposReset.push(0);

//                                                   \$(\"#divfamilyReset\").css(\"display\",\"block\");

                                                    if(\$(\"#kingdom\").val()=='')
                                                            camposReset.push(\"kingdom\");

                                                    \$(\"#kingdom\").val(item[2]);
                                                    $('#kingdomvalue').val(item[2]);
                                                    \$(\"#taxonomicelements_idkingdom\").val(item[3]);

//                                                    if (item[2]!=''){
//                                                            dasabilitaCampos(\"kingdom\");
//                                                            $('#divkingdomValor').text(item[2]);
//                                                    }else
//                                                            habilitaCampos(\"kingdom\");

                                                    if(\$(\"#phylum\").val()=='')
                                                            camposReset.push(\"phylum\");

                                                    \$(\"#phylum\").val(item[4]);
                                                    $('#phylumvalue').val(item[4]);
                                                    \$(\"#taxonomicelements_idphylum\").val(item[5]);

//                                                    if (item[4]!=''){
//                                                            dasabilitaCampos(\"phylum\");
//                                                            $('#divphylumValor').text(item[4]);
//                                                    }else
//                                                            habilitaCampos(\"phylum\");

                                                    if(\$(\"#class\").val()=='')
                                                            camposReset.push(\"class\");

                                                    \$(\"#class\").val(item[6]);
                                                    $('#classvalue').val(item[6]);
                                                    \$(\"#taxonomicelements_idclass\").val(item[7]);

//                                                    if (item[6]!=''){
//                                                            dasabilitaCampos(\"class\");
//                                                            $('#divclassValor').text(item[6]);
//                                                    }else
//                                                            habilitaCampos(\"class\");

                                                    if(\$(\"#order\").val()=='')
                                                            camposReset.push(\"order\");


                                                    \$(\"#order\").val(item[8]);
                                                    $('#ordervalue').val(item[8]);
                                                    \$(\"#taxonomicelements_idorder\").val(item[9]);

//                                                    if (item[8]!=''){
//                                                            dasabilitaCampos(\"order\");
//                                                            $('#divorderValor').text(item[8]);
//                                                    }else
//                                                            habilitaCampos(\"order\");
//
//                                                    if (item[0]!=''){
//                                                            dasabilitaCampos(\"family\");
//                                                            $('#divfamilyValor').text(item[0]);
//                                                    }else
//                                                            habilitaCampos(\"family\");

                                                    camposReset.push(\"family\");
                                                    camposPreenchidosTaxonomicElements.push(camposReset);

                                                    habilitaLinkDesfazerTaxonomicElements()
                                            })",
            ));

            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=families/list" onclick="this.href = 'index.php?r=families/list' + concatenarValoresUrlTaxonomicElements()"  rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=families/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divfamilyLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idfamily');
    echo CHtml::label(Yii::t('yii','Family'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divfamilyValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divfamilyReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divgenus'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Genus'), "taxonomicelements");?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=genus',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idgenus');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[genusvalue]', $autocompletehiddenfield['genusvalue'], array('id'=>'genusvalue'));?>
            <?php
            /*
                         *INPUT - Genus com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$genus->genus,
                    'name'=>'q',
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15,
                    'minChars'=>2,
                    'delay'=>500,
                    'matchCase'=>false,
                    'id'=>'genus',
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".setOptions({extraParams : {
                                        'formIdKingdom': function(){return \$(\"#taxonomicelements_idkingdom\").val();},
                                                'formIdPhylum': function(){return \$(\"#taxonomicelements_idphylum\").val();},
                                                'formIdClass': function(){return \$(\"#taxonomicelements_idclass\").val();},
                                                'formIdOrder': function(){return \$(\"#taxonomicelements_idorder\").val();},
                                                'formIdFamily': function(){return \$(\"#taxonomicelements_idfamily\").val();},
                                                'formIdSubgenus': function(){return \$(\"#taxonomicelements_idsubgenus\").val();},
                                                'formIdSpecificEpithet': function(){return \$(\"#taxonomicelements_idspecificepithet\").val();},
                                                'formIdInfraSpecificepithet': function(){return \$(\"#taxonomicelements_idinfraspecificepithet\").val();},
                                                'formIdScientificName': function(){return \$(\"#taxonomicelements_idscientificname\").val();},
                                                'formIdSpecificRank': function(){return \$(\"#taxonomicelements_idspecificrank\").val();},
                                                'formIdScientificNameAuthorship': function(){return \$(\"#taxonomicelements_idscientificnameauthorship\").val();},
                                                'formIdNomenclaturalCode': function(){return \$(\"#taxonomicelements_idnomenclaturalcode\").val();},
                                                'tableField':'genus'
                                                } }).result(function(event,item){
                                                        \$(\"#taxonomicelements_idgenus\").val(item[1]);
                                                        $('#genusvalue').val(item[0]);

                                                        escondeBotaoResetTaxonomicElements();
                                                                var camposReset = new Array();
                                                                camposReset.push(0);

//                                                        \$(\"#divgenusReset\").css(\"display\",\"block\");

                                                        if(\$(\"#kingdom\").val()=='')
                                                                camposReset.push(\"kingdom\");

                                                        \$(\"#kingdom\").val(item[2]);
                                                        $('#kingdomvalue').val(item[2]);
                                                        \$(\"#taxonomicelements_idkingdom\").val(item[3]);


//                                                        if (item[2]!=''){
//                                                                dasabilitaCampos(\"kingdom\");
//                                                                $('#divkingdomValor').text(item[2]);
//                                                        }else
//                                                                habilitaCampos(\"kingdom\");

                                                        if(\$(\"#phylum\").val()=='')
                                                                camposReset.push(\"phylum\");

                                                        \$(\"#phylum\").val(item[4]);
                                                        $('#phylumvalue').val(item[4]);
                                                        \$(\"#taxonomicelements_idphylum\").val(item[5]);


//                                                        if (item[4]!=''){
//                                                                dasabilitaCampos(\"phylum\");
//                                                                $('#divphylumValor').text(item[4]);
//                                                        }else
//                                                                habilitaCampos(\"phylum\");

                                                        if(\$(\"#class\").val()=='')
                                                                camposReset.push(\"class\");

                                                        \$(\"#class\").val(item[6]);
                                                        $('#classvalue').val(item[6]);
                                                        \$(\"#taxonomicelements_idclass\").val(item[7]);


//                                                        if (item[6]!=''){
//                                                                dasabilitaCampos(\"class\");
//                                                                $('#divclassValor').text(item[6]);
//                                                        }else
//                                                                habilitaCampos(\"class\");

                                                        if(\$(\"#order\").val()=='')
                                                                camposReset.push(\"order\");

                                                        \$(\"#order\").val(item[8]);
                                                        $('#ordervalue').val(item[8]);
                                                        \$(\"#taxonomicelements_idorder\").val(item[9]);


//                                                        if (item[8]!=''){
//                                                                dasabilitaCampos(\"order\");
//                                                                $('#divorderValor').text(item[8]);
//                                                        }else
//                                                                habilitaCampos(\"order\");

                                                        if(\$(\"#family\").val()=='')
                                                                camposReset.push(\"family\");

                                                        \$(\"#family\").val(item[10]);
                                                        $('#familyvalue').val(item[10]);
                                                        \$(\"#taxonomicelements_idfamily\").val(item[11]);



                                                        camposReset.push(\"genus\");
                                                        camposPreenchidosTaxonomicElements.push(camposReset);
	
                                                        habilitaLinkDesfazerTaxonomicElements()

                                                })",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=genus/list" onclick="this.href = 'index.php?r=genus/list' + concatenarValoresUrlTaxonomicElements()"  rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=genus/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>

        </td>
    </tr>
    <!--<div class="simple" id='divgenusLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idgenus');
    echo CHtml::label(Yii::t('yii','Genus'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divgenusValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divgenusReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divsubgenus'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Sub genus'), "taxonomicelements");?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subgenus',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idsubgenus');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[subgenusvalue]', $autocompletehiddenfield['subgenusvalue'], array('id'=>'subgenusvalue'));?>
            <?php
            /*
                         *INPUT - Genus com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$subgenus->subgenus,
                    'name'=>'q',
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15,
                    'minChars'=>2,
                    'delay'=>500,
                    'matchCase'=>false,
                    'id'=>'subgenus',
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".setOptions({extraParams : {
                                        'formIdKingdom': function(){return \$(\"#taxonomicelements_idkingdom\").val();},
                                                'formIdPhylum': function(){return \$(\"#taxonomicelements_idphylum\").val();},
                                                'formIdClass': function(){return \$(\"#taxonomicelements_idclass\").val();},
                                                'formIdOrder': function(){return \$(\"#taxonomicelements_idorder\").val();},
                                                'formIdFamily': function(){return \$(\"#taxonomicelements_idfamily\").val();},
                                                'formIdGenus': function(){return \$(\"#taxonomicelements_idgenus\").val();},

                                                'formIdSpecificEpithet': function(){return \$(\"#taxonomicelements_idspecificepithet\").val();},
                                                'formIdInfraSpecificepithet': function(){return \$(\"#taxonomicelements_idinfraspecificepithet\").val();},
                                                'formIdScientificName': function(){return \$(\"#taxonomicelements_idscientificname\").val();},
                                                'formIdSpecificRank': function(){return \$(\"#taxonomicelements_idspecificrank\").val();},
                                                'formIdScientificNameAuthorship': function(){return \$(\"#taxonomicelements_idscientificnameauthorship\").val();},
                                                'formIdNomenclaturalCode': function(){return \$(\"#taxonomicelements_idnomenclaturalcode\").val();},
                                                'tableField':'subgenus'
                                                } }).result(function(event,item){
                                                        \$(\"#taxonomicelements_idsubgenus\").val(item[1]);
                                                        $('#subgenusvalue').val(item[0]);

                                                        escondeBotaoResetTaxonomicElements();
                                                                var camposReset = new Array();
                                                                camposReset.push(0);

//                                                        \$(\"#divgenusReset\").css(\"display\",\"block\");

                                                        if(\$(\"#kingdom\").val()=='')
                                                                camposReset.push(\"kingdom\");

                                                        \$(\"#kingdom\").val(item[2]);
                                                        $('#kingdomvalue').val(item[2]);
                                                        \$(\"#taxonomicelements_idkingdom\").val(item[3]);


//                                                        if (item[2]!=''){
//                                                                dasabilitaCampos(\"kingdom\");
//                                                                $('#divkingdomValor').text(item[2]);
//                                                        }else
//                                                                habilitaCampos(\"kingdom\");

                                                        if(\$(\"#phylum\").val()=='')
                                                                camposReset.push(\"phylum\");

                                                        \$(\"#phylum\").val(item[4]);
                                                        $('#phylumvalue').val(item[4]);
                                                        \$(\"#taxonomicelements_idphylum\").val(item[5]);


//                                                        if (item[4]!=''){
//                                                                dasabilitaCampos(\"phylum\");
//                                                                $('#divphylumValor').text(item[4]);
//                                                        }else
//                                                                habilitaCampos(\"phylum\");

                                                        if(\$(\"#class\").val()=='')
                                                                camposReset.push(\"class\");

                                                        \$(\"#class\").val(item[6]);
                                                        $('#classvalue').val(item[6]);
                                                        \$(\"#taxonomicelements_idclass\").val(item[7]);



                                                        if(\$(\"#order\").val()=='')
                                                                camposReset.push(\"order\");

                                                        \$(\"#order\").val(item[8]);
                                                        $('#ordervalue').val(item[8]);
                                                        \$(\"#taxonomicelements_idorder\").val(item[9]);

                                                        if(\$(\"#family\").val()=='')
                                                                camposReset.push(\"family\");

                                                        \$(\"#family\").val(item[10]);
                                                        $('#familyvalue').val(item[10]);
                                                        \$(\"#taxonomicelements_idfamily\").val(item[11]);

                                                        if(\$(\"#genus\").val()=='')
                                                                camposReset.push(\"genus\");

                                                        \$(\"#genus\").val(item[12]);
                                                        $('#genusvalue').val(item[12]);
                                                        \$(\"#taxonomicelements_idgenus\").val(item[13]);

                                                        camposReset.push(\"subgenus\");
                                                        camposPreenchidosTaxonomicElements.push(camposReset);

														habilitaLinkDesfazerTaxonomicElements()
                                                })",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=subgenus/list" onclick="this.href = 'index.php?r=subgenus/list' + concatenarValoresUrlTaxonomicElements()"  rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=subgenus/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>

        </td>
    </tr>
    <!--<div class="simple" id='divsubgenusLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idgenus');
    echo CHtml::label(Yii::t('yii','Sub genus'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divsubgenusValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divsubgenusReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divspecificepithet'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Specific epithet'), "taxonomicelements");?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=specificepithet',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idspecificepithet');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[specificepithetvalue]', $autocompletehiddenfield['specificepithetvalue'], array('id'=>'specificepithetvalue'));?>
            <?php
            /*
                         *INPUT - Specific Epithet com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$specificepithet->specificepithet,
                    //name of the html field that will be generated
                    'name'=>'q',
                    //replace controller/action with real ids
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15, //specifies the max number of items to display

                    //specifies the number of chars that must be entered
                    //before autocomplete initiates a lookup
                    'minChars'=>2,
                    'delay'=>500, //number of milliseconds before lookup occurs
                    'matchCase'=>false, //match case when performing a lookup?
                    'id'=>'specificepithet',
                    //'extraParams'=>array('tableField'=>'specificepithet'),
                    //any additional html attributes that go inside of
                    //the input field can be defined here
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".setOptions({extraParams : {
                                        'formIdKingdom': function(){return \$(\"#taxonomicelements_idkingdom\").val();},
                                                'formIdPhylum': function(){return \$(\"#taxonomicelements_idphylum\").val();},
                                                'formIdClass': function(){return \$(\"#taxonomicelements_idclass\").val();},
                                                'formIdOrder': function(){return \$(\"#taxonomicelements_idorder\").val();},
                                                'formIdFamily': function(){return \$(\"#taxonomicelements_idfamily\").val();},
                                                'formIdGenus': function(){return \$(\"#taxonomicelements_idgenus\").val();},
                                                'formIdSubgenus': function(){return \$(\"#taxonomicelements_idsubgenus\").val();},
                                                'formIdInfraSpecificepithet': function(){return \$(\"#taxonomicelements_idinfraspecificepithet\").val();},
                                                'formIdScientificName': function(){return \$(\"#taxonomicelements_idscientificname\").val();},
                                                'formIdSpecificRank': function(){return \$(\"#taxonomicelements_idspecificrank\").val();},
                                                'formIdSpecificRank': function(){return \$(\"#taxonomicelements_idspecificrank\").val();},
                                                'formIdScientificNameAuthorship': function(){return \$(\"#taxonomicelements_idscientificnameauthorship\").val();},
                                                'formIdNomenclaturalCode': function(){return \$(\"#taxonomicelements_idnomenclaturalcode\").val();},
                                                'tableField':'specificepithet'
                                                } }).result(function(event,item){
                                                        \$(\"#taxonomicelements_idspecificepithet\").val(item[1]);
                                                        $('#specificepithetvalue').val(item[0]);

                                                        escondeBotaoResetTaxonomicElements();
                                                                var camposReset = new Array();
                                                                camposReset.push(0);


                                                        if(\$(\"#kingdom\").val()=='')
                                                                camposReset.push(\"kingdom\");

                                                        \$(\"#kingdom\").val(item[2]);
                                                        $('#kingdomvalue').val(item[2]);
                                                        \$(\"#taxonomicelements_idkingdom\").val(item[3]);


                                                        if(\$(\"#phylum\").val()=='')
                                                                camposReset.push(\"phylum\");


                                                        \$(\"#phylum\").val(item[4]);
                                                        $('#phylumvalue').val(item[4]);
                                                        \$(\"#taxonomicelements_idphylum\").val(item[5]);


                                                        if(\$(\"#class\").val()=='')
                                                                camposReset.push(\"class\");

                                                        \$(\"#class\").val(item[6]);
                                                        $('#classvalue').val(item[6]);
                                                        \$(\"#taxonomicelements_idclass\").val(item[7]);


                                                        if(\$(\"#order\").val()=='')
                                                                camposReset.push(\"order\");

                                                        \$(\"#order\").val(item[8]);
                                                        $('#ordervalue').val(item[8]);
                                                        \$(\"#taxonomicelements_idorder\").val(item[9]);


                                                        if(\$(\"#family\").val()=='')
                                                                camposReset.push(\"family\");

                                                        \$(\"#family\").val(item[10]);
                                                        $('#familyvalue').val(item[10]);
                                                        \$(\"#taxonomicelements_idfamily\").val(item[11]);


                                                        if(\$(\"#genus\").val()=='')
                                                                camposReset.push(\"genus\");

                                                        \$(\"#genus\").val(item[12]);
                                                        $('#genusvalue').val(item[12]);
                                                        \$(\"#taxonomicelements_idgenus\").val(item[13]);

                                                        if(\$(\"#subgenus\").val()=='')
                                                                camposReset.push(\"subgenus\");

                                                        \$(\"#subgenus\").val(item[14]);
                                                        $('#subgenusvalue').val(item[14]);
                                                        \$(\"#taxonomicelements_idsubgenus\").val(item[15]);


                                                        camposReset.push(\"specificepithet\");
                                                        camposPreenchidosTaxonomicElements.push(camposReset);
                                                        
                                                        habilitaLinkDesfazerTaxonomicElements()
                                                })",
            ));

            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=specificepithets/list" onclick="this.href = 'index.php?r=specificepithets/list' + concatenarValoresUrlTaxonomicElements()"  rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=specificepithets/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divspecificepithetLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idspecificepithet');
    echo CHtml::label(Yii::t('yii','Specific epithet'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divspecificepithetValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divspecificepithetReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divinfraspecificepithet'>-->
    <!--<tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Infraspecific epithet'), "taxonomicelements"); ?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=infraspecificepithet',array('rel'=>'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idinfraspecificepithet');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[infraspecificepithetvalue]', $autocompletehiddenfield['infraspecificepithetvalue'], array('id'=>'infraspecificepithetvalue'));?>
            <?php
            /*
                     *INPUT - Infra Specific Epithet com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$infraspecificepithet->infraspecificepithet,
                    'name'=>'q',
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15,
                    'minChars'=>2,
                    'delay'=>500,
                    'matchCase'=>false,
                    'id'=>'infraspecificepithet',
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".setOptions({extraParams : {
                                'formIdKingdom': function(){return \$(\"#taxonomicelements_idkingdom\").val();},
                                        'formIdPhylum': function(){return \$(\"#taxonomicelements_idphylum\").val();},
                                        'formIdClass': function(){return \$(\"#taxonomicelements_idclass\").val();},
                                        'formIdOrder': function(){return \$(\"#taxonomicelements_idorder\").val();},
                                        'formIdFamily': function(){return \$(\"#taxonomicelements_idfamily\").val();},
                                        'formIdGenus': function(){return \$(\"#taxonomicelements_idgenus\").val();},
                                        'formIdSubgenus': function(){return \$(\"#taxonomicelements_idsubgenus\").val();},
                                        'formIdScientificName': function(){return \$(\"#taxonomicelements_idscientificname\").val();},
                                        'formIdSpecificEpithet': function(){return \$(\"#taxonomicelements_idspecificepithet\").val();},
                                        'formIdSpecificRank': function(){return \$(\"#taxonomicelements_idspecificrank\").val();},
                                        'formIdScientificNameAuthorship': function(){return \$(\"#taxonomicelements_idscientificnameauthorship\").val();},
                                        'formIdNomenclaturalCode': function(){return \$(\"#taxonomicelements_idnomenclaturalcode\").val();},
                                        'tableField':'infraspecificepithet'
                                        } }).result(function(event,item){
                                                \$(\"#taxonomicelements_idinfraspecificepithet\").val(item[1]);
                                                $('#infraspecificepithetvalue').val(item[0]);

                                                escondeBotaoResetTaxonomicElements();
                                                        var camposReset = new Array();
                                                        camposReset.push(0);

                                                \$(\"#divinfraspecificepithetReset\").css(\"display\",\"block\");

                                                if(\$(\"#kingdom\").val()=='')
                                                        camposReset.push(\"kingdom\");

                                                \$(\"#kingdom\").val(item[2]);
                                                $('#kingdomvalue').val(item[2]);
                                                \$(\"#taxonomicelements_idkingdom\").val(item[3]);

        //	         	 		if (item[2]!=''){
        //	         	 			dasabilitaCampos(\"kingdom\");
        //	         	 			$('#divkingdomValor').text(item[2]);
        //	         	 		}else
        //	         	 			habilitaCampos(\"kingdom\");

                                                if(\$(\"#phylum\").val()=='')
                                                        camposReset.push(\"phylum\");

                                                \$(\"#phylum\").val(item[4]);
                                                $('#phylumvalue').val(item[4]);
                                                \$(\"#taxonomicelements_idphylum\").val(item[5]);

        //	         	 		if (item[4]!=''){
        //	         	 			dasabilitaCampos(\"phylum\");
        //	         	 			$('#divphylumValor').text(item[4]);
        //	         	 		}else
        //	         	 			habilitaCampos(\"phylum\");

                                                if(\$(\"#class\").val()=='')
                                                        camposReset.push(\"class\");

                                                \$(\"#class\").val(item[6]);
                                                $('#classvalue').val(item[6]);
                                                \$(\"#taxonomicelements_idclass\").val(item[7]);

        //	         	 		if (item[6]!=''){
        //	         	 			dasabilitaCampos(\"class\");
        //	         	 			$('#divclassValor').text(item[6]);
        //	         	 		}else
        //	         	 			habilitaCampos(\"class\");

                                                if(\$(\"#order\").val()=='')
                                                        camposReset.push(\"order\");

                                                \$(\"#order\").val(item[8]);
                                                $('#ordervalue').val(item[8]);
                                                \$(\"#taxonomicelements_idorder\").val(item[9]);

        //	         	 		if (item[8]!=''){
        //	         	 			dasabilitaCampos(\"order\");
        //	         	 			$('#divorderValor').text(item[8]);
        //	         	 		}else
        //	         	 			habilitaCampos(\"order\");

                                                if(\$(\"#family\").val()=='')
                                                        camposReset.push(\"family\");

                                                \$(\"#family\").val(item[10]);
                                                $('#familyvalue').val(item[10]);
                                                \$(\"#taxonomicelements_idfamily\").val(item[11]);

        //	         	 		if (item[10]!=''){
        //	         	 			dasabilitaCampos(\"family\");
        //	         	 			$('#divfamilyValor').text(item[10]);
        //	         	 		}else
        //	         	 			habilitaCampos(\"family\");

                                                if(\$(\"#genus\").val()=='')
                                                        camposReset.push(\"genus\");

                                                \$(\"#genus\").val(item[12]);
                                                $('#genusvalue').val(item[12]);
                                                \$(\"#taxonomicelements_idgenus\").val(item[13]);


                                                if(\$(\"#subgenus\").val()=='')
                                                        camposReset.push(\"subgenus\");

                                                \$(\"#subgenus\").val(item[14]);
                                                $('#subgenusvalue').val(item[14]);
                                                \$(\"#taxonomicelements_idsubgenus\").val(item[15]);

                                                if(\$(\"#specificepithet\").val()=='')
                                                        camposReset.push(\"specificepithet\");

                                                \$(\"#specificepithet\").val(item[16]);
                                                $('#specificepithetvalue').val(item[16]);
                                                \$(\"#taxonomicelements_idspecificepithet\").val(item[17]);

                                                if(\$(\"#scientificname\").val()=='')
                                                        camposReset.push(\"scientificname\");

                                                \$(\"#scientificname\").val(item[18]);
                                                $('#scientificnamevalue').val(item[18]);
                                                \$(\"#taxonomicelements_idscientificname\").val(item[19]);

      

        //	         	 		if (item[0]!=''){
        //	         	 			dasabilitaCampos(\"infraspecificepithet\");
        //	         	 			$('#divinfraspecificepithetValor').text(item[0]);
        //	         	 		}else
        //	         	 			habilitaCampos(\"infraspecificepithet\");

                                                camposReset.push(\"infraspecificepithet\");
                                                camposPreenchidosTaxonomicElements.push(camposReset);
												
                                                habilitaLinkDesfazerTaxonomicElements()
                                                ;})",
            ));

            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=infraspecificepithets/list" onclick="this.href = 'index.php?r=infraspecificepithets/list' + concatenarValoresUrlTaxonomicElements()"  rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=infraspecificepithets/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>-->
    <!--<div class="simple" id='divinfraspecificepithetLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idinfraspecificepithet');
    echo CHtml::label(Yii::t('yii','Infraspecific epithet'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divinfraspecificepithetValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divinfraspecificepithetReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->

</table>
<div class="subgroup"><?php echo Yii::t('yii','Identification'); ?></div>

<table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">

    <!--<div class="tablerow" id='divtaxonrank'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Taxon rank'), "taxonomicelements"); ?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=taxonrank',array('rel'=>'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idtaxonrank');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[taxonrankvalue]', $autocompletehiddenfield['taxonrankvalue'], array('id'=>'taxonrankvalue'));?>

            <?php
            /*
                 *INPUT - Infra Specific Rank com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$taxonranks->taxonrank,
                    //name of the html field that will be generated
                    'name'=>'q',
                    //replace controller/action with real ids
                    'url'=>'index.php?r=autocompleterecordlevelelements',
                    'max'=>15, //specifies the max number of items to display
                    //specifies the number of chars that must be entered
                    //before autocomplete initiates a lookup
                    'minChars'=>2,
                    'delay'=>500, //number of milliseconds before lookup occurs
                    'matchCase'=>false, //match case when performing a lookup?
                    'id'=>'taxonrank',
                    'extraParams'=>array('tableField'=>'taxonrank', 'table'=>'taxonranks'),
                    //any additional html attributes that go inside of
                    //the input field can be defined here
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".result(function(event,item){
                                                    \$(\"#taxonomicelements_idtaxonrank\").val(item[1]);
                                                    $('#taxonrankvalue').val(item[0]);

                                                    escondeBotaoResetTaxonomicElements();
                                                    var camposReset = new Array();
                                                    camposReset.push(0);

                                                    camposReset.push(\"taxonrank\");
                                                    camposPreenchidosTaxonomicElements.push(camposReset);

                                            })

                                            ",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=taxonranks/list"  rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=taxonranks/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divtaxonrankLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idtaxonrank');
    echo CHtml::label(Yii::t('yii','Taxon rank'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divtaxonrankValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divtaxonrankReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divscientificnameauthorship'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Scientific Name Authorship'), "taxonomicelements"); ?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificnameauthorship',array('rel'=>'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idscientificnameauthorship');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[scientificnameauthorshipvalue]', $autocompletehiddenfield['scientificnameauthorshipvalue'], array('id'=>'scientificnameauthorshipvalue'));?>

            <?php
            /*
                         *INPUT - Author Year of cientificname com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$scientificnameauthorship->scientificnameauthorship,
                    //name of the html field that will be generated
                    'name'=>'q',
                    //replace controller/action with real ids
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15, //specifies the max number of items to display
                    //specifies the number of chars that must be entered
                    //before autocomplete initiates a lookup
                    'minChars'=>2,
                    'delay'=>500, //number of milliseconds before lookup occurs
                    'matchCase'=>false, //match case when performing a lookup?
                    'id'=>'scientificnameauthorship',
                    'extraParams'=>array('tableField'=>'scientificnameauthorship'),
                    //any additional html attributes that go inside of
                    //the input field can be defined here
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".result(function(event,item){
                                                \$(\"#taxonomicelements_idscientificnameauthorship\").val(item[1]);
                                                $('#scientificnameauthorshipvalue').val(item[0]);

                                                escondeBotaoResetTaxonomicElements();
                                                                var camposReset = new Array();
                                                                camposReset.push(0);

//                                                                \$(\"#divscientificnameauthorshipReset\").css(\"display\",\"block\");
//
//                                                        if (item[0]!=''){
//                                                                dasabilitaCampos(\"scientificnameauthorship\");
//                                                                $('#divscientificnameauthorshipValor').text(item[0]);
//                                                        }else
//                                                                habilitaCampos(\"scientificnameauthorship\");

                                                        camposReset.push(\"scientificnameauthorship\");
                                                        camposPreenchidosTaxonomicElements.push(camposReset);
                                                        

                                     })",
            ));

            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=scientificnameauthorship/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=scientificnameauthorship/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>

        </td>
    </tr>
    <!--<div class="simple" id='divscientificnameauthorshipLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idscientificnameauthorship');
    echo CHtml::label(Yii::t('yii','Author year scient. name'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divscientificnameauthorshipValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divscientificnameauthorshipReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divnomenclaturalcode'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Nomenclatural code'), "taxonomicelements"); ?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=nomenclaturalcode',array('rel'=>'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idnomenclaturalcode');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[nomenclaturalcodevalue]', $autocompletehiddenfield['nomenclaturalcodevalue'], array('id'=>'nomenclaturalcodevalue'));?>
            <?php
            /*

                         *INPUT - Nomenclatural code com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$nomenclaturalcodes->nomenclaturalcode,
                    //name of the html field that will be generated
                    'name'=>'q',
                    //replace controller/action with real ids
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15, //specifies the max number of items to display
                    //specifies the number of chars that must be entered
                    //before autocomplete initiates a lookup
                    'minChars'=>2,
                    'delay'=>500, //number of milliseconds before lookup occurs
                    'matchCase'=>false, //match case when performing a lookup?
                    'id'=>'nomenclaturalcode',
                    'extraParams'=>array('tableField'=>'nomenclaturalcode'),
                    //any additional html attributes that go inside of
                    //the input field can be defined here
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".result(function(event,item){
                                                \$(\"#taxonomicelements_idnomenclaturalcode\").val(item[1]);
                                                $('#nomenclaturalcodevalue').val(item[0]);

                                                escondeBotaoResetTaxonomicElements();
                                                                var camposReset = new Array();
                                                                camposReset.push(0);

//                                                                \$(\"#divnomenclaturalcodeReset\").css(\"display\",\"block\");
//
//                                                        if (item[0]!=''){
//                                                                dasabilitaCampos(\"nomenclaturalcode\");
//                                                                $('#divnomenclaturalcodeValor').text(item[0]);
//                                                        }else
//                                                                habilitaCampos(\"nomenclaturalcode\");

                                                        camposReset.push(\"nomenclaturalcode\");
                                                        camposPreenchidosTaxonomicElements.push(camposReset);

                                     })",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=nomenclaturalcodes/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=nomenclaturalcodes/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divnomenclaturalcodeLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idnomenclaturalcode');
    echo CHtml::label(Yii::t('yii','Nomenclatural code'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divnomenclaturalcodeValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divnomenclaturalcodeReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>-->
    <!--<div class="tablerow" id='divtaxonconcept'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Taxon concept'), "taxonomicelements"); ?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=taxonconcept',array('rel'=>'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idtaxonconcept');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[taxonconceptvalue]', $autocompletehiddenfield['taxonconceptvalue'], array('id'=>'taxonconceptvalue'));?>
            <?php
            /*
                         *INPUT - Nomenclatural code com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$taxonconcept->taxonconcept,
                    //name of the html field that will be generated
                    'name'=>'q',
                    //replace controller/action with real ids
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15, //specifies the max number of items to display
                    //specifies the number of chars that must be entered
                    //before autocomplete initiates a lookup
                    'minChars'=>2,
                    'delay'=>500, //number of milliseconds before lookup occurs
                    'matchCase'=>false, //match case when performing a lookup?
                    'id'=>'taxonconcept',
                    'extraParams'=>array('tableField'=>'taxonconcept'),
                    //any additional html attributes that go inside of
                    //the input field can be defined here
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".result(function(event,item){
                                                \$(\"#taxonomicelements_idtaxonconcept\").val(item[1]);
                                                $('#taxonconceptvalue').val(item[0]);

                                                escondeBotaoResetTaxonomicElements();
                                                                var camposReset = new Array();
                                                                camposReset.push(0);
                                                        camposReset.push(\"taxonconcept\");
                                                        camposPreenchidosTaxonomicElements.push(camposReset);


                                     })",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=taxonconcept/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=taxonconcept/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divtaxonconceptLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idnomenclaturalcode');
    echo CHtml::label(Yii::t('yii','Taxon concept'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divtaxonconceptValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divtaxonconceptReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Nomenclatural status'), "taxonomicelements");?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=nomenclaturalstatus',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeTextField($taxonomicelements,'nomenclaturalstatus',array('class'=>'textboxtext')); ?>
        </td>
        <td class="tableautocel">&nbsp;</td>
        <td class="tableundocel">&nbsp;</td>
    </tr>
</table>
<div class="subgroup"><?php echo Yii::t('yii','Name data'); ?></div>

<table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">

    <!--<div class="tablerow" id='divacceptednameusage'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Accepted name usage'), "taxonomicelements"); ?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=acceptednameusage',array('rel'=>'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idacceptednameusage');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[acceptednameusagevalue]', $autocompletehiddenfield['acceptednameusagevalue'], array('id'=>'acceptednameusagevalue'));?>
            <?php
            /*
                         *INPUT - Nomenclatural code com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$acceptednameusage->acceptednameusage,
                    //name of the html field that will be generated
                    'name'=>'q',
                    //replace controller/action with real ids
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15, //specifies the max number of items to display
                    //specifies the number of chars that must be entered
                    //before autocomplete initiates a lookup
                    'minChars'=>2,
                    'delay'=>500, //number of milliseconds before lookup occurs
                    'matchCase'=>false, //match case when performing a lookup?
                    'id'=>'acceptednameusage',
                    'extraParams'=>array('tableField'=>'acceptednameusage'),
                    //any additional html attributes that go inside of
                    //the input field can be defined here
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".result(function(event,item){
                                                \$(\"#taxonomicelements_idacceptednameusage\").val(item[1]);
                                                $('#acceptednameusagevalue').val(item[0]);

                                                escondeBotaoResetTaxonomicElements();
                                                                var camposReset = new Array();
                                                                camposReset.push(0);
                                                        camposReset.push(\"acceptednameusage\");
                                                        camposPreenchidosTaxonomicElements.push(camposReset);

                                     })",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=acceptednameusage/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=acceptednameusage/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divacceptednameusageLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idnomenclaturalcode');
    echo CHtml::label(Yii::t('yii','Accepted name usage'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divacceptednameusageValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divacceptednameusageReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divparentnameusage'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Parent name usage'), "taxonomicelements"); ?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=parentnameusage',array('rel'=>'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idparentnameusage');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[parentnameusagevalue]', $autocompletehiddenfield['parentnameusagevalue'], array('id'=>'parentnameusagevalue'));?>
            <?php
            /*
                         *INPUT - Nomenclatural code com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$parentnameusage->parentnameusage,
                    //name of the html field that will be generated
                    'name'=>'q',
                    //replace controller/action with real ids
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15, //specifies the max number of items to display
                    //specifies the number of chars that must be entered
                    //before autocomplete initiates a lookup
                    'minChars'=>2,
                    'delay'=>500, //number of milliseconds before lookup occurs
                    'matchCase'=>false, //match case when performing a lookup?
                    'id'=>'parentnameusage',
                    'extraParams'=>array('tableField'=>'parentnameusage'),
                    //any additional html attributes that go inside of
                    //the input field can be defined here
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".result(function(event,item){
                                                \$(\"#taxonomicelements_idparentnameusage\").val(item[1]);
                                                $('#parentnameusagevalue').val(item[0]);

                                        		escondeBotaoResetTaxonomicElements();
                                                var camposReset = new Array();
                                                camposReset.push(0);
                                                camposReset.push(\"parentnameusage\");
                                                camposPreenchidosTaxonomicElements.push(camposReset);

                                     })",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=parentnameusage/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=parentnameusage/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divparentnameusageLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idnomenclaturalcode');
    echo CHtml::label(Yii::t('yii','Parent name usage'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divparentnameusageValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divparentnameusageReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divoriginalnameusage'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Original name usage'), "taxonomicelements"); ?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=originalnameusage',array('rel'=>'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idoriginalnameusage');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[originalnameusagevalue]', $autocompletehiddenfield['originalnameusagevalue'], array('id'=>'originalnameusagevalue'));?>
            <?php
            /*
                         *INPUT - Nomenclatural code com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$originalnameusage->originalnameusage,
                    //name of the html field that will be generated
                    'name'=>'q',
                    //replace controller/action with real ids
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15, //specifies the max number of items to display
                    //specifies the number of chars that must be entered
                    //before autocomplete initiates a lookup
                    'minChars'=>2,
                    'delay'=>500, //number of milliseconds before lookup occurs
                    'matchCase'=>false, //match case when performing a lookup?
                    'id'=>'originalnameusage',
                    'extraParams'=>array('tableField'=>'originalnameusage'),
                    //any additional html attributes that go inside of
                    //the input field can be defined here
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".result(function(event,item){
                                                \$(\"#taxonomicelements_idoriginalnameusage\").val(item[1]);
                                                $('#originalnameusagevalue').val(item[0]);

                                                escondeBotaoResetTaxonomicElements();
                                                                var camposReset = new Array();
                                                                camposReset.push(0);
                                                        camposReset.push(\"originalnameusage\");
                                                        camposPreenchidosTaxonomicElements.push(camposReset);

                                     })",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=originalnameusage/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=originalnameusage/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divoriginalnameusageLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idnomenclaturalcode');
    echo CHtml::label(Yii::t('yii','Original name usage'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divoriginalnameusageValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divoriginalnameusageReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divnameaccordingto'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Name according to'), "taxonomicelements"); ?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=nameaccordingto',array('rel'=>'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idnameaccordingto');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[nameaccordingtovalue]', $autocompletehiddenfield['nameaccordingtovalue'], array('id'=>'nameaccordingtovalue'));?>
            <?php
            /*
                         *INPUT - Nomenclatural code com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$nameaccordingto->nameaccordingto,
                    //name of the html field that will be generated
                    'name'=>'q',
                    //replace controller/action with real ids
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15, //specifies the max number of items to display
                    //specifies the number of chars that must be entered
                    //before autocomplete initiates a lookup
                    'minChars'=>2,
                    'delay'=>500, //number of milliseconds before lookup occurs
                    'matchCase'=>false, //match case when performing a lookup?
                    'id'=>'nameaccordingto',
                    'extraParams'=>array('tableField'=>'nameaccordingto'),
                    //any additional html attributes that go inside of
                    //the input field can be defined here
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".result(function(event,item){
                                                \$(\"#taxonomicelements_idnameaccordingto\").val(item[1]);
                                                $('#nameaccordingtovalue').val(item[0]);

                                                escondeBotaoResetTaxonomicElements();
                                                                var camposReset = new Array();
                                                                camposReset.push(0);
                                                        camposReset.push(\"nameaccordingto\");
                                                        camposPreenchidosTaxonomicElements.push(camposReset);


                                     })",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundcel">
            <a href="index.php?r=nameaccordingto/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=nameaccordingto/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divnameaccordingtoLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idnomenclaturalcode');
    echo CHtml::label(Yii::t('yii','Name according to'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divnameaccordingtoValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divnameaccordingtoReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <!--<div class="tablerow" id='divnamepublishedin'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Name published in'), "taxonomicelements"); ?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=namepublishedin',array('rel'=>'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($taxonomicelements,'idnamepublishedin');?>
            <?php echo CHtml::hiddenField('autocompletehiddenfield[namepublishedinvalue]', $autocompletehiddenfield['namepublishedinvalue'], array('id'=>'namepublishedinvalue'));?>
            <?php
            /*
                         *INPUT - Nomenclatural code com autocomplete
            */
            $this->widget('CAutoComplete',
                    array(
                    //value to update
                    'value'=>$namepublishedin->namepublishedin,
                    //name of the html field that will be generated
                    'name'=>'q',
                    //replace controller/action with real ids
                    'url'=>'index.php?r=autocomplete',
                    'max'=>15, //specifies the max number of items to display
                    //specifies the number of chars that must be entered
                    //before autocomplete initiates a lookup
                    'minChars'=>2,
                    'delay'=>500, //number of milliseconds before lookup occurs
                    'matchCase'=>false, //match case when performing a lookup?
                    'id'=>'namepublishedin',
                    'extraParams'=>array('tableField'=>'namepublishedin'),
                    //any additional html attributes that go inside of
                    //the input field can be defined here
                    'htmlOptions'=>array('class'=>'textboxtext'),
                    'methodChain'=>".result(function(event,item){
                                                \$(\"#taxonomicelements_idnamepublishedin\").val(item[1]);
                                                $('#namepublishedinvalue').val(item[0]);

                                                escondeBotaoResetTaxonomicElements();
                                                                var camposReset = new Array();
                                                                camposReset.push(0);
                                                        camposReset.push(\"namepublishedin\");
                                                        camposPreenchidosTaxonomicElements.push(camposReset);


                                     })",
            ));
            ?>
        </td>
        <td class="tableautocel">
            <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
        </td>
        <td class="tableundocel">
            <a href="index.php?r=namepublishedin/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=namepublishedin/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
        </td>
    </tr>
    <!--<div class="simple" id='divnamepublishedinLabel' style='display: none;'>
        <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
            <tr>
                <td style="width: 50px;" >
    <?php //echo CHtml::activeLabelEx($taxonomicelements,'idnomenclaturalcode');
    echo CHtml::label(Yii::t('yii','Name published in'), "taxonomicelements");
    ?>
                </td>
                <td style="width: 272px;">
                    <span class="simple" id='divnamepublishedinValor' ></span>
                </td>
                <td>
                    <span class="simple" id='divnamepublishedinReset' style='display:none;' >
                        <a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                </td>
            </tr>
        </table>
    </div>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Vernacular name'), "taxonomicelements");?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=vernacularname',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeTextField($taxonomicelements,'vernacularname',array('class'=>'textboxtext')); ?>
        </td>
        <td class="tableautocel">&nbsp;</td>
        <td class="tableundocel">&nbsp;</td>
    </tr>
</table>
<div class="subgroup"><?php echo Yii::t('yii','Taxon data'); ?></div>

<table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">

    <!--<div class="tablerow" id='divtaxonomicstatus'>-->
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Taxonomic status'), "taxonomicelements"); ?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=taxonomicstatus',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeDropDownList($taxonomicelements, 'idtaxonomicstatus', CHtml::listData(taxonomicstatus::model()->findAll(" 1=1 ORDER BY taxonomicstatus "), 'idtaxonomicstatus', 'taxonomicstatus'), array('empty'=>'-'));?>
        </td>
        <td class="tableautocel">&nbsp;</td>
        <td class="tableundocel">&nbsp;</td>
    </tr>
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Verbatim taxon rank'), "taxonomicelements");?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimtaxonrank',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeTextField($taxonomicelements,'verbatimtaxonrank',array('class'=>'textfield')); ?>
        </td>
        <td class="tableautocel">&nbsp;</td>
        <td class="tableundocel">&nbsp;</td>
    </tr>
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::label(Yii::t('yii','Taxon remarks'), "taxonomicelements");?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=taxonremarks',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeTextArea($taxonomicelements,'taxonremarks',array('class'=>'textarea')); ?>
        </td>
        <td class="tableautocel">&nbsp;</td>
        <td class="tableundocel">&nbsp;</td>
    </tr>
</table>

<?php
if($showActionButton) {
    echo "<div class=\"action\">";
    echo CHtml::submitButton($update ? Yii::t('yii', "Save") : Yii::t('yii', "Create"));
    echo "</div>";
}
?>
<?php if($showActionButton)
    echo CHtml::endForm();
?>

