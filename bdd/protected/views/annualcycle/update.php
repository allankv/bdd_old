<h2>Update annualcycle <?php echo $model->idannualcycle; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('annualcycle List',array('list')); ?>]
[<?php echo CHtml::link('New annualcycle',array('create')); ?>]
[<?php echo CHtml::link('Manage annualcycle',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>