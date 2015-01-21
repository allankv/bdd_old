<div class="yiiForm">

<p>
<?php echo Yii::t('yii', "Fields with * are required.");?>
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($basisofrecords); ?>

<div class="simple">
<?php //echo CHtml::activeLabelEx($basisofrecords,'basisofrecord');      
		echo CHtml::label(Yii::t('yii','Basis of record'), "basisofrecords");
?><!--<span class="required">*</span>-->
<?php echo CHtml::activeTextField($basisofrecords,'basisofrecord',array('size'=>50)); ?>
</div>

<div class="action">
<?php //echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
<input type="button" value="<?php echo Yii::t('yii', "Create");?>" onclick="insertDataRecordLevelElements($('#basisofrecord'),$('#recordlevelelements_idbasisofrecord'),'index.php?r=basisofrecords/create'+concatenarValoresUrlRecordLevelElements(),'basisofrecord='+document.getElementById('basisofrecords_basisofrecord').value)" >
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->