<h2>Update collectedby <?php echo $model->idcollectedby; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('collectedby List',array('list')); ?>]
[<?php echo CHtml::link('New collectedby',array('create')); ?>]
[<?php echo CHtml::link('Manage collectedby',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>