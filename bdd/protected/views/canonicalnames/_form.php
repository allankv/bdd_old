<div class="yiiForm">

<p>
Fields with <span class="required">*</span> are required.
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($model); ?>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'idcanonicalauthorship'); ?>
<?php echo CHtml::activeTextField($model,'idcanonicalauthorship'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'canonicalname'); ?>
<?php echo CHtml::activeTextField($model,'canonicalname'); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->