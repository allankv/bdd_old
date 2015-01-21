<h2>New languages</h2>

<div class="actionBar">
[<?php echo CHtml::link('languages List',array('list')); ?>]
[<?php echo CHtml::link('Manage languages',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>