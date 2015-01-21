<h2>New migrations</h2>

<div class="actionBar">
[<?php echo CHtml::link('migrations List',array('list')); ?>]
[<?php echo CHtml::link('Manage migrations',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>