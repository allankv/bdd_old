<h2>Update lifecycles <?php echo $model->idlifecycles; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('lifecycles List',array('list')); ?>]
[<?php echo CHtml::link('New lifecycles',array('create')); ?>]
[<?php echo CHtml::link('Manage lifecycles',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>