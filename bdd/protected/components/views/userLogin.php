<?php echo CHtml::beginForm(); ?>
<div class="form" style="font-size:11px;padding-left:20px;height:160px;">
        <div>
            <font color="green"><h3 style="margin:0px;margin-top:5px;margin-bottom:10px;font-size:15px;">Login</h3></font>
        </div>
        <div style="margin-bottom:5px;">
            <?php echo CHtml::label(Yii::t('yii', "Username"), "username", array("style"=>"height:12px;")); ?>
        </div>
        <div>
            <?php echo CHtml::activeTextField($form,'username', array("style"=>"height:16px;width:130px;", "size"=>"11px", "id"=>"inbox")) ?>
            <?php echo CHtml::error($form,'username'); ?>
        </div>
        <div style="margin-bottom:5px;margin-top:5px;">
            <?php echo CHtml::label(Yii::t('yii', "Password"), "password"); ?>
        </div>
        <div>
            <?php echo CHtml::activePasswordField($form,'password', array("style"=>"height:16px;width:130px;", "size"=>"10px",  "id"=>"inbox")) ?>
            <?php echo CHtml::error($form,'password'); ?>
        </div>
        <div>
            <?php //echo CHtml::activeCheckBox($form,'rememberMe',array('style'=>'float: left;')); ?>
        </div>
        <div>
            <?php //echo CHtml::label(Yii::t('yii', "Remember me"), "remeberMe"); ?>
        </div>
        <div style="padding-right:10px;padding-top:10px;text-align: right;">
            <?php echo CHtml::submitButton('Login', array("style"=>"height:22px;width:45px;font-size:9px;padding:0px;margin:0px;vertical-align:top;")); ?>
        </div>
</div>
<?php echo CHtml::endForm(); ?>