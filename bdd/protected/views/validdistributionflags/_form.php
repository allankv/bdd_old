<div class="yiiForm">

<p>
<?php echo Yii::t('yii', "Fields with * are required.");?>
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($validdistributionflags); ?>

<div class="simple">
<?php //echo CHtml::activeLabelEx($validdistributionflags,'validdistributionflag');        
		echo CHtml::label(Yii::t('yii','Valid distribution flag'), "validdistributionflags");
?><span class="required">*</span>
<?php echo CHtml::activeTextField($validdistributionflags,'validdistributionflag'); ?>
</div>

<div class="action">
<?php //echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
<input type="button" value="<?php echo Yii::t('yii', "Create");?>" onclick="insertDataCollectingEventElements($('#validdistributionflag'),$('#validdistributionflags_idvaliddistributionflag'),'index.php?r=validdistributionflags/create'+concatenarValoresUrlCollectingEventElements(),'validdistributionflag='+document.getElementById('validdistributionflags_validdistributionflag').value)" >
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->