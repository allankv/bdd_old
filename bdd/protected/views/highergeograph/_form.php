<div class="yiiForm">

<p>
Fields with <span class="required">*</span> are required.
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($model); ?>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'highergeographid'); ?>
<?php echo CHtml::activeTextField($model,'highergeographid',array('size'=>60,'maxlength'=>60)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'highergeograph'); ?>
<?php echo CHtml::activeTextArea($model,'highergeograph',array('rows'=>6, 'cols'=>50)); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->