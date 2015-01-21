<h2>Update originalnameusage <?php echo $model->idoriginalnameusage; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('originalnameusage List',array('list')); ?>]
[<?php echo CHtml::link('New originalnameusage',array('create')); ?>]
[<?php echo CHtml::link('Manage originalnameusage',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>