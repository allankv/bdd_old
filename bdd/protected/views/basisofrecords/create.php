<h2><?php echo Yii::t('yii', "New basis of record");?></h2>

<div class="actionBar">
<!-- 
[<?php //echo CHtml::link('basisofrecords List',array('list')); ?>]
[<?php //echo CHtml::link('Manage basisofrecords',array('admin')); ?>]
 -->
</div>

<?php echo $this->renderPartial('_form', array(
	'basisofrecords'=>$basisofrecords,
	'update'=>false,
)); ?>