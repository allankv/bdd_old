<h2>Update languages <?php echo $model->idlanguages; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('languages List',array('list')); ?>]
[<?php echo CHtml::link('New languages',array('create')); ?>]
[<?php echo CHtml::link('Manage languages',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>