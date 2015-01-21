<h2>New publishers</h2>

<div class="actionBar">
[<?php echo CHtml::link('publishers List',array('list')); ?>]
[<?php echo CHtml::link('Manage publishers',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>