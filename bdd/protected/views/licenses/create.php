<h2>New licenses</h2>

<div class="actionBar">
[<?php echo CHtml::link('licenses List',array('list')); ?>]
[<?php echo CHtml::link('Manage licenses',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>