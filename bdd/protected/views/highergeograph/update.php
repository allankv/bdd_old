<h2>Update highergeograph <?php echo $model->idhighergeograph; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('highergeograph List',array('list')); ?>]
[<?php echo CHtml::link('New highergeograph',array('create')); ?>]
[<?php echo CHtml::link('Manage highergeograph',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>