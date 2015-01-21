<h2>New annualcycle</h2>

<div class="actionBar">
[<?php echo CHtml::link('annualcycle List',array('list')); ?>]
[<?php echo CHtml::link('Manage annualcycle',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>