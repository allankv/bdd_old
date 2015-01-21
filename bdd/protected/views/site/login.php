<?php $this->pageTitle=Yii::app()->name . ' - Login'; ?>

<h1>Login</h1>

<div class="yiiForm">
<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($form); ?>

<div class="simple">
<?php echo CHtml::label(Yii::t('yii', "Email"), "email"); ?>
<?php echo CHtml::activeTextField($form,'email') ?>
</div>

<div class="simple">
<?php echo CHtml::label(Yii::t('yii', "Senha"), "senha"); ?>
<?php echo CHtml::activePasswordField($form,'senha') ?>
<p class="hint">
<?php echo Yii::t('yii', 'Hint: You may login with')." <tt>admin/admin</tt>.";?>
</p>
</div>

<div class="action">
<?php echo CHtml::activeCheckBox($form,'rememberMe'); ?>
<?php echo CHtml::label(Yii::t('yii', "Remember me next time"), "remeberme"); ?>
<br/>
<?php echo CHtml::submitButton('Login'); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->