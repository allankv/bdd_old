<h2><?php echo Yii::t('yii', "New valid distribution");?></h2>

<div class="actionBar">
<!-- 
[<?php //echo CHtml::link('validdistributionflags List',array('list')); ?>]
[<?php //echo CHtml::link('Manage validdistributionflags',array('admin')); ?>]
 -->
</div>

<?php echo $this->renderPartial('_form', array(
	'validdistributionflags'=>$validdistributionflags,
	'update'=>false,
)); ?>