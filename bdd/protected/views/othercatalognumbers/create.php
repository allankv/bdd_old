<h2>New othercatalognumbers</h2>

<div class="actionBar">
[<?php echo CHtml::link('othercatalognumbers List',array('list')); ?>]
[<?php echo CHtml::link('Manage othercatalognumbers',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>