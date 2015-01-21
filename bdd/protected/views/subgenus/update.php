<h2>Update subgenus <?php echo $model->idsubgenus; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('subgenus List',array('list')); ?>]
[<?php echo CHtml::link('New subgenus',array('create')); ?>]
[<?php echo CHtml::link('Manage subgenus',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>