<h2>Update taxonomicstatus <?php echo $model->idtaxonomicstatus; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('taxonomicstatus List',array('list')); ?>]
[<?php echo CHtml::link('New taxonomicstatus',array('create')); ?>]
[<?php echo CHtml::link('Manage taxonomicstatus',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>