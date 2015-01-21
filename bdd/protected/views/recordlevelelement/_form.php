
<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/lightbox/recordlevelelements.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/lightbox/localityelements.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/validation/validationdata.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/validation/jquery.numeric.pack.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/autocomplete.js",CClientScript::POS_END);
$cs->registerScriptFile("js/loadfields.js",CClientScript::POS_END);
?>

<script type="text/javascript">
    document.onload = hide();
    function hide(){
        $('#b').hide();
    }
    function show(){
        $('#b').fadeIn(2000);
        $('#b').contents().find('#btngoback').click(function() {
            $('.yiiForm').show();
            $('#b').fadeOut(1000);
        });
        $('#b').contents().find('#btnselect').click(function() {
            $('.yiiForm').show();
            $('#b').fadeOut(1000);

            $('#geospatialelements_decimallatitude').val($('#b').contents().find('#lat').html());
            $('#geospatialelements_decimallongitude').val($('#b').contents().find('#lng').html());
            getGeoDataWS();
            $('#localityelements_minimumelevationinmeters').val($('#b').contents().find('#alt').html());
            $('#localityelements_maximumelevationinmeters').val($('#b').contents().find('#alt').html());

        });
        $('.yiiForm').hide();
    }

    function getGeoDataWS(){
        $('#form').scrollTop(300);
        $('#localityelements_minimumelevationinmeters').val('');
        $('#localityelements_maximumelevationinmeters').val('');
        var latitude = $('#geospatialelements_decimallatitude').val();
        var longitude = $('#geospatialelements_decimallongitude').val();
        if(latitude.length>1&&longitude.length>1){
            $.ajax({url:'index.php?r=georeferencingtool/getGeoDataWS&latitude='+latitude+'&longitude='+longitude,
                type: 'GET',
                success: function(data){
                    var country = data.split("|")[0];
                    var state = data.split("|")[1];
                    var municipality = data.split("|")[2];
                    $("#country").val(country);
                    $("#stateprovince").val(state);
                    $("#municipality").val(municipality);
                    $.ajax({url:'index.php?r=georeferencingtool/save&country='+country+'&state='+state+'&municipality='+municipality,
                        type: 'GET',
                        success: function(data){
                           $("#localityelements_idcountry").val(data.split("|")[0]);
                           $("#localityelements_idstateprovince").val(data.split("|")[1]);
                           $("#localityelements_idmunicipality").val(data.split("|")[2]);
                        }
                    });
                }
            });
        }
    }

</script>

<!-- FORMUL�RIO ----------------------------------------------->
<?php echo CHtml::beginForm(); ?>

<!-- Nao deveria aparecer so' se nao for salvo?-->
<div style="margin-left:120px;"><?php //if(!$salvo) $this->widget('FieldsErrors',array('models'=>array($occurrenceelements,$recordlevelelements,$taxonomicelements,$eventelements,$localityelements,$geospatialelements))); ?></div>
<?php echo CHtml::hiddenField('message0',Yii::t('yii','Select the option auto-complete/List for a field already registered or New to define a new value.'));?>
<?php echo CHtml::hiddenField('message1',Yii::t('yii','For new value use NEW'));?>

<br/>

<div class="yiiForm" id="form">

    <!-- Icone de Required -->
    <?php if($salvo) {  ?>
    <div class="success">
        <h2 style="margin:0px;padding:0px;"><?php echo Yii::t('yii','Record saved successfully'); ?></h2>
        <p style="margin:0px;padding:0px;padding-top:10px;letter-spacing:2px;">
            [<?php echo CHtml::label($recordlevelelements->basisofrecord->basisofrecord, "recordlevelelements");?>]
            [<?php echo CHtml::label($institutioncodes->institutioncode, "recordlevelelements");?>]
            [<?php echo CHtml::label($collectioncodes->collectioncode, "recordlevelelements");?>]
            [<b> <?php echo CHtml::label($catalognumbersalvo, "recordlevelelements"); ?></b>]
        </p>
    </div>
        <?php }?>

    <div class="attention">
        <?php echo CHtml::image('images/main/attention.png','',array('border'=>'0px'))."&nbsp;".Yii::t('yii', "Main Fields");?>
        (<span style="color: red; font-weight: bold;"><?php echo Yii::t('yii',"Fields with * are required"); ?></span>)
    </div>

    <table cellspacing="0" cellpadding="0" align="center" class="tablerequired">
        <?php echo CHtml::activeHiddenField($recordlevelelements,'globaluniqueidentifier');?>
        <tr> <!-- id='divbasisofrecord'-->
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Basis of record'), "recordlevelelements"); ?>
                <span class="required">*</span>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=basisofrecord',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeDropDownList($recordlevelelements, 'idbasisofrecord', CHtml::listData(basisofrecords::model()->findAll(" 1=1 ORDER BY basisofrecord "), 'idbasisofrecord', 'basisofrecord'), array('empty'=>'-'));?>
            </td>
            <td class="acIcon"></td>
        </tr>
        <tr>
            <!--<div class="tablerow" id='divinstitutioncode'>-->
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Institution code'), "recordlevelelements");?>
                <span class="required">*</span>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=institutioncode',array('rel'=>'lightbox'));?>

            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($recordlevelelements,'idinstitutioncode');?>
                    <?php echo CHtml::hiddenField('autocompletehiddenfield[institutioncodevalue]', ($update ? $recordlevelelements->institutioncode->institutioncode : $autocompletehiddenfield['institutioncodevalue']), array('id'=>'institutioncodevalue'));?>
                    <?php
                    $this->widget('CAutoComplete',
                            array(
                            'value'=>$institutioncodes->institutioncode,
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
                            'id'=>'institutioncode',
                            'extraParams'=>array('tableField'=>'institutioncode', 'table'=>'institutioncodes'),
                            //any additional html attributes that go inside of
                            //the input field can be defined here
                            'htmlOptions'=>array('class'=>'textboxtext'),
                            'methodChain'=>".result(function(event,item){\$(\"#recordlevelelements_idinstitutioncode\").val(item[1]);
                                                                    $('#institutioncodevalue').val(item[0]);

                                                                    escondeBotaoResetRecordLevelElements();
                                                                    var camposReset = new Array();
                                                                    camposReset.push(0);

                                                                    //\$(\"#divinstitutioncodeReset\").css(\"display\",\"block\");

//                                                                    if (item[0]!=''){
//                                                                            dasabilitaCampos(\"institutioncode\");
//                                                                            $('#divinstitutioncodeValor').text(item[0]);
//                                                                    }else
//                                                                            habilitaCampos(\"institutioncode\");

                                                                    camposReset.push(\"institutioncode\");
                                                                    camposPreenchidosRecordLevelElements.push(camposReset);


                                                 })",
                    ));
                    ?>
                </div>
            </td>
            <td class="tableautocel">
                <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
            </td>
            <td class="tableundocel">
                <a href="index.php?r=institutioncodes/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
                &nbsp;&nbsp;&nbsp;<a href="index.php?r=institutioncodes/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
            </td>


        </tr>

        <!-- O que � isto? São as divs que mantinham o undo que o diogo havia feito!
        <div class="simple" id='divinstitutioncodeLabel' style='display: none;'>
            <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
                <tr>
                    <td style="width: 50px;" >
        <?php echo CHtml::activeLabelEx($recordlevelelements,'idinstitutioncode');

        ?>
                    </td>s
                    <td style="width: 272px;">
                        <span class="simple" id='divinstitutioncodeValor' ></span>
                    </td>
                    <td>
                        <span class="simple" id='divinstitutioncodeReset' style='display:none;' >
                            &nbsp;<a href="#" onclick=limpaCamposRecordLevelElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                    </td>
                </tr>
            </table>
        </div>-->
        <!--<div class="tablerow" id='divcollectioncode'>-->
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Collection code'), "recordlevelelements");?>
                <span class="required">*</span>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collectioncode',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeHiddenField($recordlevelelements,'idcollectioncode'); ?>
                <?php echo CHtml::hiddenField('autocompletehiddenfield[collectioncodevalue]', $autocompletehiddenfield['collectioncodevalue'], array('id'=>'collectioncodevalue'));?>
                <?php
                $this->widget('CAutoComplete',
                        array(
                        'value'=>$collectioncodes->collectioncode,
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
                        'id'=>'collectioncode',
                        'extraParams'=>array('tableField'=>'collectioncode', 'table'=>'collectioncodes'),
                        //any additional html attributes that go inside of
                        //the input field can be defined here
                        'htmlOptions'=>array('class'=>'textboxtext'),
                        'methodChain'=>".result(function(event,item){\$(\"#recordlevelelements_idcollectioncode\").val(item[1]);
                                                                    $('#collectioncodevalue').val(item[0]);

                                                                    escondeBotaoResetRecordLevelElements();
                                                                    var camposReset = new Array();
                                                                    camposReset.push(0);

                                                                    //\$(\"#divcollectioncodeReset\").css(\"display\",\"block\");

                                                                    if (item[0]!=''){
                                                                            //dasabilitaCampos(\"collectioncode\");
                                                                            //$('#divcollectioncodeValor').text(item[0]);
                                                                    }else
                                                                            habilitaCampos(\"collectioncode\");

                                                                    camposReset.push(\"collectioncode\");
                                                                    camposPreenchidosRecordLevelElements.push(camposReset);

                                                 })",
                ));
                ?>
            </td>
            <td class="tableautocel">
                <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
            </td>
            <td class="tableundocel">
                <a href="index.php?r=collectioncodes/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
                &nbsp;&nbsp;&nbsp;<a href="index.php?r=collectioncodes/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
            </td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Catalog number'), "occurrenceelements");?>
                <span class="required">*</span>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=catalognumber',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($occurrenceelements,'catalognumber',array('class'=>'textboxtext')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
        <tr>
            <!--<div class="tablerow" id='divscientificname'>-->
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Scientific name'), "taxonomicelements"); ?>
                    <!--<span class="required">*</span>-->
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificname',array('rel'=>'lightbox')); ?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeHiddenField($taxonomicelements,'idscientificname');?>
                <?php echo CHtml::hiddenField('autocompletehiddenfield[scientificnamevalue]', $autocompletehiddenfield['scientificnamevalue'], array('id'=>'scientificnamevalue'));?>
                <?php
                /*
                    *INPUT - Scientific name com autocomplete
                */
                $this->widget('CAutoComplete',
                        array(
                        //value to update
                        'value'=>$scientificnames->scientificname,
                        'name'=>'q',
                        'url'=>'index.php?r=autocomplete',
                        'max'=>15,
                        'minChars'=>2,
                        'delay'=>500,
                        'matchCase'=>false,
                        'id'=>'scientificname',
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
                                        'formIdSpecificEpithet': function(){return \$(\"#taxonomicelements_idspecificepithet\").val();},
                                        'formIdSpecificRank': function(){return \$(\"#taxonomicelements_idspecificrank\").val();},
                                        'formIdScientificNameAuthorship': function(){return \$(\"#taxonomicelements_idscientificnameauthorship\").val();},
                                        'formIdNomenclaturalCode': function(){return \$(\"#taxonomicelements_idnomenclaturalcode\").val();},
                                        'tableField':'scientificname'
                                        } }).result(function(event,item){
                                                \$(\"#taxonomicelements_idscientificname\").val(item[1]);
                                                $('#scientificnamevalue').val(item[0]);

                                                escondeBotaoResetTaxonomicElements();
                                                var camposReset = new Array();
                                                camposReset.push(0);
//                                                \$(\"#divscientificnameReset\").css(\"display\",\"block\");

                                                if(\$(\"#kingdom\").val()=='')
                                                        camposReset.push(\"kingdom\");

                                                \$(\"#kingdom\").val(item[2]);
                                                $('#kingdomvalue').val(item[2]);
                                                \$(\"#taxonomicelements_idkingdom\").val(item[3]);

//                                                if (item[2]!=''){
//                                                        dasabilitaCampos(\"kingdom\");
//                                                        $('#divkingdomValor').text(item[2]);
//                                                }else
//                                                        habilitaCampos(\"kingdom\");

                                                if(\$(\"#phylum\").val()=='')
                                                        camposReset.push(\"phylum\");


                                                \$(\"#phylum\").val(item[4]);
                                                $('#phylumvalue').val(item[4]);
                                                \$(\"#taxonomicelements_idphylum\").val(item[5]);

//                                                if (item[4]!=''){
//                                                        dasabilitaCampos(\"phylum\");
//                                                        $('#divphylumValor').text(item[4]);
//                                                }else
//                                                        habilitaCampos(\"phylum\");

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



                                                if(\$(\"#specificepithet\").val()=='')
                                                        camposReset.push(\"specificepithet\");

                                                \$(\"#specificepithet\").val(item[16]);
                                                $('#specificepithetvalue').val(item[16]);
                                                \$(\"#taxonomicelements_idspecificepithet\").val(item[17]);

                                                camposReset.push(\"scientificname\");
                                                camposPreenchidosTaxonomicElements.push(camposReset);

                                                habilitaLabelDesfazerTaxonomicElements();

                                        })",
                ));

                ?>
            </td>
            <td class="tableautocel">
                <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
            </td>
            <td class="tableundocel">
                <a href="index.php?r=scientificnames/list" onclick="this.href = 'index.php?r=scientificnames/list' + concatenarValoresUrlTaxonomicElements()"  rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
                &nbsp;&nbsp;&nbsp;<a href="index.php?r=scientificnames/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
                &nbsp;&nbsp;
                <div style="display: none;" id="labelLimparTaxonomicElements"  >
                    <a href="javascript:limparCamposTaxonomicElements()" ><?php echo Yii::t('yii','Clean'); ?></a>
                </div>
            </td>
        </tr>
        <!--<div class="simple" id='divscientificnameLabel' style='display: none;'>
            <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
                <tr>
                    <td style="width: 50px;" >
        <?php //echo CHtml::activeLabelEx($taxonomicelements,'idscientificname');
        echo CHtml::label(Yii::t('yii','Scientific name'), "taxonomicelements");
        ?>
                    </td>
                    <td style="width: 272px;">
                        <span class="simple" id='divscientificnameValor' ></span>
                    </td>
                    <td>
                        <span class="simple" id='divscientificnameReset' style='display:none;' >
                            &nbsp;<a href="#" onclick=limpaCamposTaxonomicElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                    </td>
                </tr>
            </table>
        </div>--><!--

        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::label(Yii::t('yii','County'), "localityelements"); ?>
            </td>
            <td class="tablemiddlecel">
                <?php //echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=county',array('rel'=>'lightbox')); ?>
            </td>
            <td class="tablefieldcel">
                <?php //echo CHtml::activeHiddenField($localityelements,'idcounty'); ?>
                <?php //echo CHtml::hiddenField('autocompletehiddenfield[countyvalue]', $autocompletehiddenfield['countyvalue'], array('id'=>'countyvalue')); ?>
                <?php
                /*$this->widget('CAutoComplete',
                        array(
                        'value'=>$counties->county,
                        //name of the html field that will be generated
                        'name'=>'q',
                        //replace controller/action with real ids
                        'url'=>'index.php?r=autocompletelocalityelements',
                        'max'=>15, //specifies the max number of items to display

                        //specifies the number of chars that must be entered
                        //before autocomplete initiates a lookup
                        'minChars'=>2,
                        'delay'=>500, //number of milliseconds before lookup occurs
                        'matchCase'=>false, //match case when performing a lookup?
                        'id'=>'county',
                        //any additional html attributes that go inside of
                        //the input field can be defined here
                        'htmlOptions'=>array('class'=>'textboxtext'),
                        'methodChain'=>".setOptions({extraParams : {
	                                                'formIdWaterbody': function(){return \$(\"#localityelements_idwaterbody\").val();},
	                                                'formIdIslandGroup': function(){return \$(\"#localityelements_idislandgroup\").val();},
	                                                'formIdIsland': function(){return \$(\"#localityelements_idisland\").val();},
	                                                'formIdCountry': function(){return \$(\"#localityelements_idcountry\").val();},
	                                                'formIdStateprovince': function(){return \$(\"#localityelements_idstateprovince\").val();},
	                                                'formIdContinent': function(){return \$(\"#localityelements_idcontinent\").val();},
	                                                'formIdMunicipality': function(){return \$(\"#localityelements_idmunicipality\").val();},
	                                                'formIdLocality': function(){return \$(\"#localityelements_idlocality\").val();},
	                                                'formIdHabitat': function(){return \$(\"#localityelements_idhabitat\").val();},
	                                                'tableField':'county'
	                                          } }).result(function(event,item){
	                                                \$(\"#localityelements_idcounty\").val(item[1]);
	                                                \$(\"#countyvalue\").val(item[0]);

	                                                escondeBotaoResetLocalityElements();
							var camposReset = new Array();
							camposReset.push(0);

	                                                \$(\"#localityelements_idcontinent\").val(item[3]);
	                                                \$(\"#continentvalue\").val(item[2]);
	                                                \$(\"#continent\").val(item[2]);

	                                                \$(\"#localityelements_idwaterbody\").val(item[5]);
	                                                \$(\"#waterbodyvalue\").val(item[4]);
	                                                \$(\"#waterbody\").val(item[4]);

	                                                \$(\"#localityelements_idislandgroup\").val(item[7]);
	                                                \$(\"#islandgroupvalue\").val(item[6]);
	                                                \$(\"#islandgroup\").val(item[6]);

	                                                \$(\"#localityelements_idisland\").val(item[9]);
	                                                \$(\"#islandvalue\").val(item[8]);
	                                                \$(\"#island\").val(item[8]);

	                                                \$(\"#localityelements_idcountry\").val(item[11]);
	                                                \$(\"#countryvalue\").val(item[10]);
	                                                \$(\"#country\").val(item[10]);

	                                                \$(\"#localityelements_idstateprovince\").val(item[13]);
	                                                \$(\"#stateprovincevalue\").val(item[12]);
	                                                \$(\"#stateprovince\").val(item[12]);

	//                                          \$(\"#divcountyReset\").css(\"display\",\"block\");
	//
	//                                          if (item[0]!=''){
	//	         	 			dasabilitaCampos(\"county\");
	//	         	 			$('#divcountyValor').text(item[0]);
	//                                          }else
	//	         	 			habilitaCampos(\"county\");

	                                            camposReset.push(\"county\");
	                                            camposPreenchidosLocalityElements.push(camposReset);

	                                            habilitaLinkDesfazerLocalityElements();

		             })",
                ));*/
                ?>
            </td>
            <td class="tableautocel">
                <?php //echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
            </td>
            <td class="tableundocel">
                <a href="index.php?r=counties/list" rel="lightbox" ><?php //echo Yii::t('yii',"List");?></a>
                &nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=counties/create" rel="lightbox" ><?php //echo Yii::t('yii',"New");?></a>
            </td>
        </tr>


        --><!--<div class="tablerow" id='divmunicipality'>-->
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Municipality'), "localityelements"); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=municipality',array('rel'=>'lightbox')); ?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeHiddenField($localityelements,'idmunicipality'); ?>
                <?php echo CHtml::hiddenField('autocompletehiddenfield[municipalityvalue]', $autocompletehiddenfield['municipalityvalue'], array('id'=>'municipalityvalue')); ?>
                <?php

                $this->widget('CAutoComplete',
                        array(
                        'value'=>$municipalities->municipality,
                        //name of the html field that will be generated
                        'name'=>'q',
                        //replace controller/action with real ids
                        'url'=>'index.php?r=autocompletelocalityelements',
                        'max'=>15, //specifies the max number of items to display
                        'cacheLength'=>1,
                        //specifies the number of chars that must be entered
                        //before autocomplete initiates a lookup
                        'minChars'=>2,
                        'delay'=>500, //number of milliseconds before lookup occurs
                        'matchCase'=>false, //match case when performing a lookup?
                        'id'=>'municipality',
                        'matchSubset'=>false,
                        //any additional html attributes that go inside of
                        //the input field can be defined here
                        'htmlOptions'=>array('class'=>'textboxtext'),
                        'methodChain'=>".setOptions({extraParams : {
                                                'formIdWaterbody': function(){return \$(\"#localityelements_idwaterbody\").val();},
                                                'formIdIslandGroup': function(){return \$(\"#localityelements_idislandgroup\").val();},
                                                'formIdIsland': function(){return \$(\"#localityelements_idisland\").val();},
                                                'formIdCountry': function(){return \$(\"#localityelements_idcountry\").val();},
                                                'formIdStateprovince': function(){return \$(\"#localityelements_idstateprovince\").val();},
                                                'formIdCounty': function(){return \$(\"#localityelements_idcounty\").val();},
                                                'formIdContinent': function(){return \$(\"#localityelements_idcontinent\").val();},
                                                'formIdLocality': function(){return \$(\"#localityelements_idlocality\").val();},
                                                'formIdHabitat': function(){return \$(\"#localityelements_idhabitat\").val();},
                                                'tableField':'municipality'
                                          } }).result(function(event,item){
                                                \$(\"#localityelements_idmunicipality\").val(item[1]);
                                                \$(\"#municipalityvalue\").val(item[0]);

                                                escondeBotaoResetLocalityElements();
                                                var camposReset = new Array();
						camposReset.push(0);

                                                \$(\"#localityelements_idcontinent\").val(item[3]);
                                                \$(\"#continentvalue\").val(item[2]);
                                                \$(\"#continent\").val(item[2]);

                                                \$(\"#localityelements_idwaterbody\").val(item[5]);
                                                \$(\"#waterbodyvalue\").val(item[4]);
                                                \$(\"#waterbody\").val(item[4]);

                                                \$(\"#localityelements_idislandgroup\").val(item[7]);
                                                \$(\"#islandgroupvalue\").val(item[6]);
                                                \$(\"#islandgroup\").val(item[6]);

                                                \$(\"#localityelements_idisland\").val(item[9]);
                                                \$(\"#islandvalue\").val(item[8]);
                                                \$(\"#island\").val(item[8]);

                                                \$(\"#localityelements_idcountry\").val(item[11]);
                                                \$(\"#countryvalue\").val(item[10]);
                                                \$(\"#country\").val(item[10]);

                                                \$(\"#localityelements_idstateprovince\").val(item[13]);
                                                \$(\"#stateprovincevalue\").val(item[12]);
                                                \$(\"#stateprovince\").val(item[12]);

                                                \$(\"#localityelements_idcounty\").val(item[15]);
                                                \$(\"#countyvalue\").val(item[14]);
                                                \$(\"#county\").val(item[14]);

//                                              \$(\"#divmunicipalityReset\").css(\"display\",\"block\");
//
//                                              if (item[0]!=''){
//                                                  dasabilitaCampos(\"municipality\");
//                                                  $('#divmunicipalityValor').text(item[0]);
//                                              }else
//                                                  habilitaCampos(\"municipality\");

                                                camposReset.push(\"municipality\");
                                                camposPreenchidosLocalityElements.push(camposReset);

                                                habilitaLabelDesfazerLocalityElements();

	             })",
                ));
                ?>
            </td>
            <td class="tableautocel">
                <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
            </td>
            <td class="tableundocel">

<!--                <a href="index.php?r=municipality/list" rel="lightbox" ><?php echo Yii::t('yii',"List");?></a>
                &nbsp;&nbsp;&nbsp;--><a href="index.php?r=municipality/create" rel="lightbox" ><?php echo Yii::t('yii',"New");?></a>
                &nbsp;&nbsp;
                <span style="display: none;" id="labelLimparLocalityElementsMunicipality"  >
                    <a href="javascript:limparCamposLocalityElements()" ><?php echo Yii::t('yii','Clean'); ?></a>
                </span>
            </td>
        </tr>

        <!--<div class="tablerow" id='divlocality'>-->
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Locality'), "localityelements"); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=locality',array('rel'=>'lightbox')); ?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeHiddenField($localityelements,'idlocality'); ?>
                <?php echo CHtml::hiddenField('autocompletehiddenfield[localityvalue]', $autocompletehiddenfield['localityvalue'], array('id'=>'localityvalue')); ?>
                <?php
                $this->widget('CAutoComplete',
                        array(
                        'value'=>$localities->locality,
                        //name of the html field that will be generated
                        'name'=>'q',
                        //replace controller/action with real ids
                        'url'=>'index.php?r=autocompletelocalityelements',
                        'max'=>15, //specifies the max number of items to display
                        'cacheLength'=>1,
                        'matchSubset'=>false,
                        //specifies the number of chars that must be entered
                        //before autocomplete initiates a lookup
                        'minChars'=>2,
                        'delay'=>500, //number of milliseconds before lookup occurs
                        'matchCase'=>false, //match case when performing a lookup?
                        'id'=>'locality',
                        //any additional html attributes that go inside of
                        //the input field can be defined here
                        'htmlOptions'=>array('class'=>'textboxtext'),
                        'methodChain'=>".setOptions({extraParams : {
                                                'formIdWaterbody': function(){return \$(\"#localityelements_idwaterbody\").val();},
                                                'formIdIslandGroup': function(){return \$(\"#localityelements_idislandgroup\").val();},
                                                'formIdIsland': function(){return \$(\"#localityelements_idisland\").val();},
                                                'formIdCountry': function(){return \$(\"#localityelements_idcountry\").val();},
                                                'formIdStateProvince': function(){return \$(\"#localityelements_idstateprovince\").val();},
                                                'formIdCounty': function(){return \$(\"#localityelements_idcounty\").val();},
                                                'formIdMunicipality': function(){return \$(\"#localityelements_idmunicipality\").val();},
                                                'formIdContinent': function(){return \$(\"#localityelements_idcontinent\").val();},
                                                'formIdHabitat': function(){return \$(\"#localityelements_idhabitat\").val();},
                                                'tableField':'locality'
                                          } }).result(function(event,item){
                                                \$(\"#localityelements_idlocality\").val(item[1]);
                                                \$(\"#localityvalue\").val(item[0]);

                                                escondeBotaoResetLocalityElements();
						var camposReset = new Array();
						camposReset.push(0);

                                                \$(\"#localityelements_continent\").val(item[3]);
                                                \$(\"#continentvalue\").val(item[2]);
                                                \$(\"#continent\").val(item[2]);

                                                \$(\"#localityelements_idwaterbody\").val(item[5]);
                                                \$(\"#waterbodyvalue\").val(item[4]);
                                                \$(\"#waterbody\").val(item[4]);

                                                \$(\"#localityelements_idislandgroup\").val(item[7]);
                                                \$(\"#islandgroupvalue\").val(item[6]);
                                                \$(\"#islandgroup\").val(item[6]);

                                                \$(\"#localityelements_idisland\").val(item[9]);
                                                \$(\"#islandvalue\").val(item[8]);
                                                \$(\"#island\").val(item[8]);

                                                \$(\"#localityelements_idcountry\").val(item[11]);
                                                \$(\"#countryvalue\").val(item[10]);
                                                \$(\"#country\").val(item[10]);

                                                \$(\"#localityelements_idstateprovince\").val(item[13]);
                                                \$(\"#stateprovincevalue\").val(item[12]);
                                                \$(\"#stateprovince\").val(item[12]);

                                                \$(\"#localityelements_idcounty\").val(item[15]);
                                                \$(\"#countyvalue\").val(item[14]);
                                                \$(\"#county\").val(item[14]);

                                                \$(\"#localityelements_idmunicipality\").val(item[17]);
                                                \$(\"#municipalityvalue\").val(item[16]);
                                                \$(\"#municipality\").val(item[16]);

//                                        		\$(\"#divlocalityReset\").css(\"display\",\"block\");
//
						//	         	 		if (item[0]!=''){
						//	         	 			dasabilitaCampos(\"locality\");
						//	         	 			$('#divlocalityValor').text(item[0]);
						//	         	 		}else
						//	         	 			habilitaCampos(\"locality\");

                                                camposReset.push(\"locality\");
                                                camposPreenchidosLocalityElements.push(camposReset);

                                                habilitaLabelDesfazerLocalityElements();

	             })",
                ));
                ?>
            </td>
            <td class="tableautocel">
                <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
            </td>
            <td class="tableundocel">
                <a href="index.php?r=localities/list" rel="lightbox" ><?php echo Yii::t('yii',"List");?></a>
                &nbsp;&nbsp;&nbsp;<a href="index.php?r=localities/create" rel="lightbox" ><?php echo Yii::t('yii',"New");?></a>
                &nbsp;&nbsp;
                <div style="display: none;" id="labelLimparLocalityElementsLocality"  >
                    <a href="javascript:limparCamposLocalityElements()" ><?php echo Yii::t('yii','Clean'); ?></a>
                </div>
            </td>

            <!--<div class="simple" id='divlocalityLabel' style='display: none;'>
                <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
                    <tr>
                        <td style="width: 50px;" >
            <?php //echo CHtml::activeLabelEx($localityelements,'idlocality');
            echo CHtml::label(Yii::t('yii','Locality'), "localityelements");
            ?>
                        </td>
                        <td style="width: 272px;">
                            <span class="simple" id='divlocalityValor' ></span>
                        </td>
                        <td>
                            <span class="simple" id='divlocalityReset' style='display:none;' >
                                &nbsp;<a href="#" onclick="limpaCamposLocalityElements()"   ><?php echo Yii::t('yii',"Undo");?></a></span>
                        </td>
                    </tr>
                </table>
            </div>-->
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Decimal latitude'), "geospatialelements");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=decimallatitude',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialelements,'decimallatitude', array('class'=>'textboxnumber','onblur'=>'getGeoDataWS();')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <!--<td class="tableundocel">
                <a href="index.php?r=searchlocality&q=#q%3D" ><?php echo Yii::t('yii', "Geospatial data tool");?></a>
            </td>-->

        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Decimal longitude'), "geospatialelements");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=decimallongitude',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialelements,'decimallongitude', array('class'=>'textboxnumber','onblur'=>'getGeoDataWS();')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <!--<td class="tableundocel">
            <?php echo CHtml::submitButton(Yii::t('yii','Geospatial data tool'), array('submit'=>'index.php?r=searchlocality'));?>
            </td>-->

        </tr>
        <tr>
            <td class="tableautocel">
                <?php echo CHtml::label('', "geospatialelements");?>
            </td>
            <td class="tableautocel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=geotool',array('rel'=>'lightbox'));?>
            </td>
            <td align="center" valign="middle" style="vertical-align: middle;">
                <a onclick="show();" style="vertical-align: middle;"><b style="vertical-align: middle; color: olive">Georeferencing Tool</b> &nbsp; <img style="vertical-align: middle;" height="24px" border="0px" src="images/main/mundo.png"/></a>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
        <!--
        <tr>
            <td class="tablelabelcel">
        <?php //echo CHtml::label(Yii::t('yii','Event date'), "eventelements");?>
            </td>
            <td class="tablemiddlecel">
        <?php //echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=eventdate',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
        <?php
        /*$this->widget('application.extensions.jui.EDatePicker',
                        array(
                        'name'=>'eventelements[eventdate]',
                        'language'=>'en',
                        'mode'=>'imagebutton',
                        'theme'=>'cupertino',
                        'value'=>$eventelements->eventdate,
                        'dateformat'=>'mm/dd/yy',
                        'htmlOptions'=>array('size'=>'13px'),
                        )
                );*/
        ?>
                <font style="font-size: 10px;">mm/dd/yyyy</font>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
        --></table>

    <div class="privateRecord"  style="margin-top:10px;">
        <?php echo CHtml::activeCheckBox($recordlevelelements, 'isrestricted')."&nbsp;&nbsp;".Yii::t('yii','Check here to make this record private')."&nbsp;&nbsp;".CHtml::image("images/main/private.gif", "",array("style"=>"border:0px;")); ?>
    </div>

    <!-- Include no JQuery -->
    <?php $this->widget('application.extensions.jui.EJqueryUiInclude', array('theme'=>'cupertino'));?>
    <!-- In�cio do Componente -->
    <?php $this->beginWidget('application.extensions.jui.EAccordion',array('name'=>'accordion1','useEasing'=>true,'options'=>array('active'=>false,'autoHeight'=>false,'clearStyle'=>false,'animated'=>'bounceslide', 'collapsible'=>true)));?>

    <!-- In�cio do Painel Record-Level -->
    <?php $this->beginWidget('application.extensions.jui.EAccordionPanel', array('name'=>'RL', 'title'=>Yii::t('yii',"Record-level elements"))); ?>

    <div class="subgroup"><?php echo Yii::t('yii','Identification'); ?></div>

    <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
        <!--<div class="tablerow" id='divtypes'>-->
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Type'), "recordlevelelements"); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=type',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeDropDownList($recordlevelelements, 'idtypes', CHtml::listData(types::model()->findAll(array('order'=>'types')), 'idtypes', 'types'), array('empty'=>'-'));?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
        <!--<div class="tablerow" id='divownerinstitution'>-->
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Owner institution code'), "recordlevelelements");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=ownerinstitution',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($recordlevelelements,'idownerinstitution');?>
                    <?php //echo CHtml::hiddenField('ownerinstitutionvalue');?>
                    <?php echo CHtml::hiddenField('autocompletehiddenfield[ownerinstitutionvalue]', $autocompletehiddenfield['ownerinstitutionvalue'], array('id'=>'ownerinstitutionvalue'));?>
                    <?php
                    $this->widget('CAutoComplete',
                            array(
                            'value'=>$ownerinstitutions->ownerinstitution,
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
                            'id'=>'ownerinstitution',
                            'extraParams'=>array('tableField'=>'ownerinstitution', 'table'=>'ownerinstitution'),
                            //any additional html attributes that go inside of
                            //the input field can be defined here
                            'htmlOptions'=>array('class'=>'textboxtext'),
                            'methodChain'=>".result(function(event,item){\$(\"#recordlevelelements_idownerinstitution\").val(item[1]);
                                                                    $('#ownerinstitutionvalue').val(item[0]);

                                                                    escondeBotaoResetRecordLevelElements();
                                                                    var camposReset = new Array();
                                                                    camposReset.push(0);

                                                                    //\$(\"#divownerinstitutionReset\").css(\"display\",\"block\");

//                                                                    if (item[0]!=''){
//                                                                            dasabilitaCampos(\"ownerinstitution\");
//                                                                            $('#divownerinstitutionValor').text(item[0]);
//                                                                    }else
//                                                                            habilitaCampos(\"ownerinstitution\");

                                                                    camposReset.push(\"ownerinstitution\");
                                                                    camposPreenchidosRecordLevelElements.push(camposReset);


                                                 })",
                    ));
                    ?>
                </div>
            </td>
            <td class="tableautocel">
                <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
            </td>
            <td class="tableundocel">
                <a href="index.php?r=ownerinstitution/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
                &nbsp;&nbsp;&nbsp;<a href="index.php?r=ownerinstitution/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
            </td>
        </tr>
        <!--
        <div class="simple" id='divownerinstitutionLabel' style='display: none;'>
            <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
                <tr>
                    <td style="width: 50px;" >
        <?php echo CHtml::activeLabelEx($recordlevelelements,'idownerinstitution');

        ?>
                    </td>
                    <td style="width: 272px;">
                        <span class="simple" id='divownerinstitutionValor' ></span>
                    </td>
                    <td>
                        <span class="simple" id='divownerinstitutionReset' style='display:none;' >
                            &nbsp;<a href="#" onclick=limpaCamposRecordLevelElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="simple" id='divcollectioncodeLabel' style='display: none;'>
            <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
                <tr>
                    <td style="width: 50px;" >
        <?php echo CHtml::label(Yii::t('yii','Collection code'), "recordlevelelements");?>
                    </td>
                    <td style="width: 272px;">
                        <span class="simple" id='divcollectioncodeValor' ></span>
                    </td>
                    <td>
                        <span class="simple" id='divcollectioncodeReset' style='display:none;' >
                            &nbsp;<a href="#" onclick=limpaCamposRecordLevelElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                    </td>
                </tr>
            </table>
        </div>
        -->
        <!-- recordedby -->
        <!--<div class="tablerow" id='divdataset'>-->
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Dataset'), "recordlevelelements");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=dataset',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeHiddenField($recordlevelelements,'iddataset'); ?>
                <?php //echo CHtml::hiddenField('datasetvalue');?>
                <?php echo CHtml::hiddenField('autocompletehiddenfield[datasetvalue]', $autocompletehiddenfield['datasetvalue'], array('id'=>'datasetvalue'));?>
                <?php
                $this->widget('CAutoComplete',
                        array(
                        'value'=>$datasets->dataset,
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
                        'id'=>'dataset',
                        'extraParams'=>array('tableField'=>'dataset', 'table'=>'dataset'),
                        //any additional html attributes that go inside of
                        //the input field can be defined here
                        'htmlOptions'=>array('class'=>'textboxtext'),
                        'methodChain'=>".result(function(event,item){
                                                                    \$(\"#recordlevelelements_iddataset\").val(item[1]);
                                                                    \$(\"#datasetvalue\").val(item[0]);
                                                                    escondeBotaoResetRecordLevelElements();
                                                                    var camposReset = new Array();
                                                                    camposReset.push(0);
                                                                    if (item[0] ==''){
                                                                        habilitaCampos(\"dataset\");
                                                                        camposReset.push(\"dataset\");
                                                                        camposPreenchidosRecordLevelElements.push(camposReset);
                                                                    }

                                                                })",
                ));
                ?>
            </td>
            <td class="tableautocel">
                <?php echo CHtml::image('images/main/ico_gear.png','',array('border'=>'0px'));?>
            </td>
            <td class="tableundocel">
                <a href="index.php?r=dataset/list" rel="lightbox" ><?php echo Yii::t('yii', "List");?></a>
                &nbsp;&nbsp;&nbsp;<a href="index.php?r=dataset/create" rel="lightbox" ><?php echo Yii::t('yii', "New");?></a>
            </td>
        </tr>
        <!--<div class="simple" id='divdatasetLabel' style='display: none;'>
            <table style="border: 0px;width: 100%;" cellpadding="0px;" cellspacing="0px;">
                <tr>
                    <td style="width: 50px;" >
        <?php echo CHtml::label(Yii::t('yii','Dataset'), "recordlevelelements");?>
                    </td>
                    <td style="width: 272px;">
                        <span class="simple" id='divdatasetValor' ></span>
                    </td>
                    <td>
                        <span class="simple" id='divdatasetReset' style='display:none;' >
                            &nbsp;<a href="#" onclick=limpaCamposRecordLevelElements()   ><?php echo Yii::t('yii', "Undo");?></a></span>
                    </td>
                </tr>
            </table>
        </div>-->
    </table>

    <div class="subgroup"><?php echo Yii::t('yii','Rights'); ?></div>

    <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Rights'), "recordlevelelements");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=rights',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($recordlevelelements,'rights',array('class'=>'textboxtext')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Rights holder'), "recordlevelelements");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=rightsholder',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($recordlevelelements,'rightsholder',array('class'=>'textboxtext')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Access rights'), "recordlevelelements");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=accessrights',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($recordlevelelements,'accessrights',array('class'=>'textboxtext')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>

    </table>

    <div class="subgroup"><?php echo Yii::t('yii','Other Information'); ?></div>

    <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">

        <!--<div class="tablerow">
            <td class="tablelabelcel">
                <div class="label">
        <?php //echo CHtml::label(Yii::t('yii','Bibliographic citation'), "recordlevelelements");?>
                </div>
            </div>
            <td class="tablemiddlecel">
        <?php //echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=bibliographiccitation',array('rel'=>'lightbox'));?>
            </div>
            <td class="tablefieldcel">
                <div class="field">
        <?php //echo CHtml::activeTextArea($recordlevelelements,'bibliographiccitation',array('class'=>'textarea')); ?>
                </div>
            </div>
        </div>-->
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Information withheld'), "recordlevelelements");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=informationwithheld',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextArea($recordlevelelements,'informationwithheld',array('class'=>'textarea')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Data generalizations'), "recordlevelelements");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=datageneralizations',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextArea($recordlevelelements,'datageneralizations',array('class'=>'textarea')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Dynamic properties'), "recordlevelelements");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=dynamicproperties',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextArea($recordlevelelements,'dynamicproperties',array('class'=>'textarea')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
    </table>

    <br/>
    <!-- In�cio do Painel Record-Level -->
    <?php $this->endWidget('application.extensions.jui.EAccordionPanel'); ?>


    <!-- Occurrence Elements -->
    <?php $this->beginWidget('application.extensions.jui.EAccordionPanel', array('name'=>'OCC', 'title'=>Yii::t('yii',"Occurrence elements"))); ?>
    <?php
    echo Yii::app()->controller->renderPartial('/occurrenceelements/_form', array(
    'occurrenceelements'=>$occurrenceelements,
    'sexes'=>$sexes,
    'lifestages'=>$lifestages,
    'establishmentmeans'=>$establishmentmeans,
    'behavior'=>$behavior,
    'disposition'=>$disposition,
    'recordedby'=>$recordedby,
    'individual'=>$individual,
    'associatedsequences'=>$associatedsequences,
    'preparations'=>$preparations,
    'reproductivecondition'=>$reproductivecondition,
    'recordlevelelements'=>$recordlevelelements,
    'autocompletehiddenfield'=>$autocompletehiddenfield,
    'update'=>$update,
    'showActionButton'=>false,
    ));
    ?>
    <br/>
    <?php $this->endWidget('application.extensions.jui.EAccordionPanel'); ?>
    <!-- Occurrence Elements -->


    <!-- Curatorial Elements -->
    <?php $this->beginWidget('application.extensions.jui.EAccordionPanel', array('name'=>'CU', 'title'=>Yii::t('yii',"Curatorial elements"))); ?>
    <br/>
    <?php
    echo Yii::app()->controller->renderPartial('/curatorialelements/_form', array(
    'curatorialelements'=>$curatorialelements,
    'recordlevelelements'=>$recordlevelelements,
    'typestatus'=>$typestatus,
    'dispositioncur'=>$dispositioncur,
    'identifiedbycur'=>$identifiedbycur,
    'associatedsequencescur'=>$associatedsequencescur,
    'preparationscur'=>$preparationscur,
    'autocompletehiddenfield'=>$autocompletehiddenfield,
    'update'=>$update,
    'showActionButton'=>false,
    ));
    ?>
    <br/>
    <?php $this->endWidget('application.extensions.jui.EAccordionPanel'); ?>
    <!-- Curatorial Elements -->

    <!-- Identification Elements-->
    <?php $this->beginWidget('application.extensions.jui.EAccordionPanel', array('name'=>'ID', 'title'=>Yii::t('yii',"Identification elements"))); ?>
    <br/>
    <?php
    echo Yii::app()->controller->renderPartial('/identificationelements/_form', array(
    'identificationelements'=>$identificationelements,
    'identificationqualifiers'=>$identificationqualifiers,
    'autocompletehiddenfield'=>$autocompletehiddenfield,
    'recordlevelelements'=>$recordlevelelements,
    'identifiedby'=>$identifiedby,
    'typestatusident'=>$typestatusident,
    'autocompletehiddenfield'=>$autocompletehiddenfield,
    'update'=>$update,
    'showActionButton'=>false,
    ));
    ?>
    <br/>
    <?php $this->endWidget('application.extensions.jui.EAccordionPanel'); ?>
    <!-- Identification Elements-->

    <!-- Event Elements -->
    <?php $this->beginWidget('application.extensions.jui.EAccordionPanel', array('name'=>'EVENT', 'title'=>Yii::t('yii',"Event elements"))); ?>
    <br/>
    <?php
    echo Yii::app()->controller->renderPartial('/eventelements/_form', array(
    'eventelements'=>$eventelements,
    'habitats'=>$habitats,
    'samplingprotocols'=>$samplingprotocols,
    'recordlevelelements'=>$recordlevelelements,
    'autocompletehiddenfield'=>$autocompletehiddenfield,
    'update'=>$update,
    'showActionButton'=>false,
    ));
    ?>
    <br/>
    <?php $this->endWidget('application.extensions.jui.EAccordionPanel'); ?>
    <!-- Event Elements -->

    <!-- Taxonomic Elements -->
    <?php $this->beginWidget('application.extensions.jui.EAccordionPanel', array('name'=>'TE', 'title'=>Yii::t('yii',"Taxonomic elements"))); ?>
    <?php
    echo Yii::app()->controller->renderPartial('/taxonomicelements/_form', array(
    'taxonomicelements'=>$taxonomicelements,
    'kingdoms'=>$kingdoms,
    'phylums'=>$phylums,
    'classes'=>$classes,
    'orders'=>$orders,
    'families'=>$families,
    'genus'=>$genus,
    'specificepithets'=>$specificepithets,
    'scientificnames'=>$scientificnames,
    'infraspecificepithets'=>$infraspecificepithets,
    'taxonranks'=>$taxonranks,
    'scientificnameauthorship'=>$scientificnameauthorship,
    'nomenclaturalcodes'=>$nomenclaturalcodes,
    'subgenus'=>$subgenus,
    'specificepithet'=>$specificepithet,
    'infraspecificepithet'=>$infraspecificepithet,
    'acceptednameusage'=>$acceptednameusage,
    'parentnameusage'=>$parentnameusage,
    'originalnameusage'=>$originalnameusage,
    'nameaccordingto'=>$nameaccordingto,
    'namepublishedin'=>$namepublishedin,
    'taxonconcept'=>$taxonconcept,
    'recordlevelelements'=>$recordlevelelements,
    'autocompletehiddenfield'=>$autocompletehiddenfield,
    'update'=>$update,
    'showActionButton'=>false,
    ));
    ?>
    <br/>
    <?php $this->endWidget('application.extensions.jui.EAccordionPanel'); ?>
    <!-- TaxonomicElements -->

    <!-- LocalityElements -->
    <?php $this->beginWidget('application.extensions.jui.EAccordionPanel', array('name'=>'LE', 'title'=>Yii::t('yii',"Locality element"))); ?>
    <?php
    echo Yii::app()->controller->renderPartial('/localityelements/_form', array(
    'localityelements'=>$localityelements,
    'localities'=>$localities,
    'municipalities'=>$municipalities,
    'habitatslocality'=>$habitatslocality,
    'waterbodies'=>$waterbodies,
    'islandgroups'=>$islandgroups,
    'islands'=>$islands,
    'counties'=>$counties,
    'countries'=>$countries,
    'stateprovinces'=>$stateprovinces,
    'continents'=>$continents,
    'recordlevelelements'=>$recordlevelelements,
    'georeferencedby'=>$georeferencedby,
    'georeferencesources'=>$georeferencesources,
    'georeferenceverificationstatus'=> $georeferenceverificationstatus,
    'autocompletehiddenfield'=>$autocompletehiddenfield,
    'update'=>$update,
    'showActionButton'=>false,
    ));
    ?>
    <br/>
    <?php $this->endWidget('application.extensions.jui.EAccordionPanel'); ?>
    <!-- LocalityElements -->

    <!-- Geospatial elements -->
    <?php $this->beginWidget('application.extensions.jui.EAccordionPanel', array('name'=>'GE', 'title'=>Yii::t('yii',"Geospatial elements"))); ?>
    <?php
    echo Yii::app()->controller->renderPartial('/geospatialelements/_form', array(
    'geospatialelements'=>$geospatialelements,
    'recordlevelelements'=>$recordlevelelements,
    'georeferencesourcesgeo'=>$georeferencesourcesgeo,
    'georeferenceverificationstatus'=>$georeferenceverificationstatus,
    'update'=>$update,
    'showActionButton'=>false,
    ));
    ?>
    <br/>
    <?php $this->endWidget('application.extensions.jui.EAccordionPanel'); ?>
    <!-- Geospatial elements -->

    <?php $this->endWidget('application.extensions.jui.EAccordion'); ?>

    <div class="actionnew">
        <?php echo CHtml::submitButton($update ? Yii::t('yii', "Save") : Yii::t('yii', "Insert"),
        array("style"=>"width:140px;height:30px;font-size:9pt;font-family:verdana;")); ?>
    </div>

</div>

<?php echo CHtml::endForm(); ?>

