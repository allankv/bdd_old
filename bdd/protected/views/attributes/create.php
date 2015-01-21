<h2>New attributes</h2>

<div class="actionBar">
[<?php echo CHtml::link('attributes List',array('list')); ?>]
[<?php echo CHtml::link('Manage attributes',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'attributes'=>$attributes,
	'update'=>false,
)); ?>