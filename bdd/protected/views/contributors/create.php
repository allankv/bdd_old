<h2>New contributors</h2>

<div class="actionBar">
[<?php echo CHtml::link('contributors List',array('list')); ?>]
[<?php echo CHtml::link('Manage contributors',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>