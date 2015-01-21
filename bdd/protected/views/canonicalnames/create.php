<h2>New canonicalnames</h2>

<div class="actionBar">
[<?php echo CHtml::link('canonicalnames List',array('list')); ?>]
[<?php echo CHtml::link('Manage canonicalnames',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>