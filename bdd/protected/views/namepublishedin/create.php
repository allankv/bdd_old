<div class="table" style="background-image: url('images/help/retangulo cinza2.png');background-repeat: no-repeat ;width: 554px; height: 365px;">
    <div style="width: 554px; height: 80px;">
        <div>
        <?php echo CHtml::image("images/help/iconenew.png","",array("style"=>"padding-left: 30px; padding-top: 20px ; float: left;")); ?>
            <div style="padding-left: 30px; padding-top: 20px ; float: left; color: #535353; font-size: 24px; font-family: Verdana;">
        <?php echo Yii::t('yii', "New Name published in");?>
        </div>
        </div>
    </div>

    <div>
        <?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>
    </div>
</div>