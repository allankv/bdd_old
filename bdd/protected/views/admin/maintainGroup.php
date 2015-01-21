<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="js/validation/jquery.numeric.pack.js"></script>
<script type="text/javascript" src="js/jquery.jstepper.js"></script>
<script type="text/javascript" src="js/loadfields.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/Geo.js"></script>
<script type="text/javascript" src="js/Taxon.js"></script>
<script type="text/javascript" src="js/Maintain.js"></script>
<script type="text/javascript" src="js/specimen.sliding.form.js"></script>
<link rel="stylesheet" type="text/css" href="css/specimen.sliding.form.css"/>
<link rel="stylesheet" href="http://www.emposha.com/demo/fcbkcomplete_2/style.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="js/jquery.fcbkcomplete.js"></script>

<style type="text/css">
    #project-label {
        color: #AA5511;
        margin-bottom: 1em;
    }
    #project-level {
        color: #AA5511;
        font-weight: bold;
    }
    #project-icon {
        float: right;
        height: 32px;
    }
    #project-description {
        margin: 0;
        padding: 0;
        font-size: small;
    }
</style>
<script type="text/javascript">	
    
    $(document).ready(bootSpecimen);
    function bootSpecimen(){

        //Configs
        configInitial();
        configNotify();
        configIcons();
    }   
             
    // Configuracoes iniciais
    function configInitial() {   

        $("#groups_group").blur();  
        $("#groups_group").focus();  
        $("#saveBtn").button();
        $("#btnGeoreferencing").button();
        // Evento onclick do botao save
        $("#saveBtn").click(function() {
            $('html, body').animate({scrollTop: 0}, 'slow');
            $('#saveBtn').button('option', 'label', 'Processing');
            $('#saveBtn').attr('checked', true);
            save();
        });
        
    }
   
    function save(){
    	
    	$.ajax({ type:'POST',
    	    url:'index.php?r=admin/saveGroups',
    	    data: $("#form").serialize(),
    	    dataType: "json",
    	    success:function(json) {
    	       //showMessage(json.msg, json.success, false);
    	       alert(json.msg);
    	       $("#saveBtn").button("option", "label", "Save" );
    	       $('#saveBtn').attr("checked", false);
    	       $("#saveBtn").button("refresh");

    	       window.location.replace("index.php?r=admin/goToListGroups");

    	    }
    	});

    	        
    }
    

</script>

<div id="Notification"></div>

<div class="introText">
    <h1><?php echo $ar->idGroup != null ? Yii::t('yii', 'Update an existing group record') : Yii::t('yii', 'Create a new group record'); ?></h1>
    <p><?php //echo Yii::t('yii', "Use this tool to save records based on modern biological specimens' information, their spatiotemporal occurrence, and their supporting evidence housed in collections (physical or digital). This set of fields is based on international standards, such as Darwin Core, Dublin Core and their extensions."); ?><BR></p>

    <div class="attention">
        <?php echo CHtml::image('images/main/attention.png', '', array('border' => '0px')) . "&nbsp;" . Yii::t('yii', "Main Fields"); ?>
        (<span style="color: red; font-weight: bold;"><?php echo Yii::t('yii', "Fields with * are required"); ?></span>)
    </div>
</div>

<?php echo CHtml::beginForm('', 'post', array('id' => 'form')); ?>
<?php echo CHtml::activeHiddenField($ar, 'idGroup'); ?>


<div class="yiiForm" style="width:90%; margin-bottom:20px; margin-left:100px;">
    <div id="contentSpecimen">
        <div class="normalFields">
      <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
        <div class="tablerow" id='divtitle'>
            <tr>
                <td class="tablelabelcel">
					<div style="margin-left:30px;"> <?php echo CHtml::activeLabel($ar, "group name"); ?>
					<span class="required">*</span> </div>
				</td>
				<td class="tablemiddlecel">
					<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=title', array('rel' => 'lightbox')); ?>
				</td>
				<td class="tablefieldcel">
					<?php echo CHtml::activeTextField($ar, 'group', array('class' => 'textboxtext')); ?>
				 </td>
			 </tr>
		</div>
		</table>
	</div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>
<div class="saveButton" style="width:84.9%; margin: 10px 0 10px 100px;">
    <input type="checkbox" id="saveBtn" /><label for="saveBtn">Save</label>
</div>

