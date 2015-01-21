<h2>Update lifeexpectancies <?php echo $model->idlifeexpectancies; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('lifeexpectancies List',array('list')); ?>]
[<?php echo CHtml::link('New lifeexpectancies',array('create')); ?>]
[<?php echo CHtml::link('Manage lifeexpectancies',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>