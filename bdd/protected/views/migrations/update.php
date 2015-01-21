<h2>Update migrations <?php echo $model->idmigration; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('migrations List',array('list')); ?>]
[<?php echo CHtml::link('New migrations',array('create')); ?>]
[<?php echo CHtml::link('Manage migrations',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>