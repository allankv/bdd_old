<h2>New lifecycles</h2>

<div class="actionBar">
[<?php echo CHtml::link('lifecycles List',array('list')); ?>]
[<?php echo CHtml::link('Manage lifecycles',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>