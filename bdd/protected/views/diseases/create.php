<h2>New diseases</h2>

<div class="actionBar">
[<?php echo CHtml::link('diseases List',array('list')); ?>]
[<?php echo CHtml::link('Manage diseases',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>