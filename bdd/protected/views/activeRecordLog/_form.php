<div class="yiiForm">

<p>
Fields with <span class="required">*</span> are required.
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($activerecordlog); ?>

<div class="simple">
<?php echo CHtml::activeLabelEx($activerecordlog,'description'); ?>
<?php echo CHtml::activeTextField($activerecordlog,'description',array('size'=>60,'maxlength'=>255)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($activerecordlog,'action'); ?>
<?php echo CHtml::activeTextField($activerecordlog,'action',array('size'=>20,'maxlength'=>20)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($activerecordlog,'model'); ?>
<?php echo CHtml::activeTextField($activerecordlog,'model',array('size'=>45,'maxlength'=>45)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($activerecordlog,'idModel'); ?>
<?php echo CHtml::activeTextField($activerecordlog,'idModel'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($activerecordlog,'field'); ?>
<?php echo CHtml::activeTextField($activerecordlog,'field',array('size'=>45,'maxlength'=>45)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($activerecordlog,'creationdate'); ?>
<?php echo CHtml::activeTextField($activerecordlog,'creationdate'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($activerecordlog,'userid'); ?>
<?php echo CHtml::activeTextField($activerecordlog,'userid',array('size'=>45,'maxlength'=>45)); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->