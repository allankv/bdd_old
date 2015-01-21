<h2>Update licenses <?php echo $model->idlicenses; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('licenses List',array('list')); ?>]
[<?php echo CHtml::link('New licenses',array('create')); ?>]
[<?php echo CHtml::link('Manage licenses',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>