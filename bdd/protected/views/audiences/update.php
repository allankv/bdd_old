<h2>Update audiences <?php echo $model->idaudiences; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('audiences List',array('list')); ?>]
[<?php echo CHtml::link('New audiences',array('create')); ?>]
[<?php echo CHtml::link('Manage audiences',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>