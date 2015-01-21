<div class="yiiForm">

<p>
Fields with <span class="required">*</span> are required.
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($users); ?>

<div class="simple">
<?php echo CHtml::activeLabelEx($users,'idGroup'); ?>
<?php //echo CHtml::activeTextField($users,'idGroup'); ?>
<?php echo CHtml::activeDropDownList($users, "idGroup", CHtml::listData(groups::model()->findAll(), "idGroup", "group"));?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($users,'username'); ?>
<?php echo CHtml::activeTextField($users,'username',array('size'=>50,'maxlength'=>50)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($users,'password'); ?>
<?php echo CHtml::passwordField('users[password]', '', array('rows'=>6, 'cols'=>50)) ?>
<?php echo CHtml::activeHiddenField($users, 'password', array('name'=>'oldPassword')) ?>
<?php //echo CHtml::activePasswordField($users,'password',array('rows'=>6, 'cols'=>50)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($users,'email'); ?>
<?php echo CHtml::activeTextArea($users,'email',array('rows'=>6, 'cols'=>50)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($users,'idUserAdd'); ?>
<?php echo CHtml::activeTextField($users,'idUserAdd'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($users,'dateValidated'); ?>
<?php echo CHtml::activeTextField($users,'dateValidated'); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->