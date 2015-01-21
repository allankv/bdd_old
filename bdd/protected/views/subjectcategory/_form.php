<div class="yiiForm">

<p>
Fields with <span class="required">*</span> are required.
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($model); ?>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'subjectcategory'); ?>
<?php echo CHtml::activeTextField($model,'subjectcategory',array('size'=>50,'maxlength'=>50)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'idsubjectcategoryvocabulary'); ?>
<?php echo CHtml::activeTextField($model,'idsubjectcategoryvocabulary'); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->