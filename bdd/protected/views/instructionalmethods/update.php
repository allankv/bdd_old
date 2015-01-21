<h2>Update instructionalmethods <?php echo $model->idinstructionalmethods; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('instructionalmethods List',array('list')); ?>]
[<?php echo CHtml::link('New instructionalmethods',array('create')); ?>]
[<?php echo CHtml::link('Manage instructionalmethods',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>