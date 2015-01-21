<div class="yiiForm">

<p>
Fields with <span class="required">*</span> are required.
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($attributes); ?>

<div class="simple">
<?php echo CHtml::activeLabelEx($attributes,'attribute'); ?>
<?php echo CHtml::activeTextArea($attributes,'attribute',array('rows'=>6, 'cols'=>50)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($attributes,'description'); ?>
<?php echo CHtml::activeTextArea($attributes,'description',array('rows'=>6, 'cols'=>50)); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->