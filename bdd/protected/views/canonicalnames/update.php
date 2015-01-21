<h2>Update canonicalnames <?php echo $model->idcanonicalnames; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('canonicalnames List',array('list')); ?>]
[<?php echo CHtml::link('New canonicalnames',array('create')); ?>]
[<?php echo CHtml::link('Manage canonicalnames',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>