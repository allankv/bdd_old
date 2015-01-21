<h2>Update acceptednameusage <?php echo $model->idacceptednameusage; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('acceptednameusage List',array('list')); ?>]
[<?php echo CHtml::link('New acceptednameusage',array('create')); ?>]
[<?php echo CHtml::link('Manage acceptednameusage',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>