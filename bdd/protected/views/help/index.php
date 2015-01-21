<div style="width: 554px; background-color: #f4f4f4; margin:auto; -moz-border-radius-topleft: 1.0em; -moz-border-radius-topright: 1.0em; -moz-border-radius-bottomleft: 1.0em; -moz-border-radius-bottomright: 1.0em; border: 1px solid #ccc;">
    <div style="margin:35px;margin-top:25px;margin-bottom:0px;color:gray;font-size:22px;font-weight:bold;height:30px;">
        <?php echo CHtml::image("images/help/icone2.png","",array("style"=>"")); ?> &nbsp;&nbsp;
        <?php ENT_QUOTES; echo Yii::t('yii', $title); ?>
    </div>
    <div style="display:block;" class="texthelp">
        <label><b><?php echo Yii::t('yii', "Definition"); ?>: </b></label><br/><br/><?php ENT_QUOTES; echo Yii::t('yii', $message); ?>
        <br/>
        <br/>
        <label><b><?php echo Yii::t('yii', "Comment"); ?>: </b></label><br/><br/><?php ENT_QUOTES; echo Yii::t('yii', $comment); ?>
        <br/>
        <br/>
        <label><b><?php echo Yii::t('yii', "References"); ?>: </b></label><br/><br/><?php ENT_QUOTES; echo Yii::t('yii', $reference); ?>
        <br/>
        <br/>
    </div>
</div>