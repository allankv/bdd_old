<h2>New typereferences</h2>

<div class="actionBar">
[<?php echo CHtml::link('typereferences List',array('list')); ?>]
[<?php echo CHtml::link('Manage typereferences',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>