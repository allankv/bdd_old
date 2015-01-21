<h2>New collectedby</h2>

<div class="actionBar">
[<?php echo CHtml::link('collectedby List',array('list')); ?>]
[<?php echo CHtml::link('Manage collectedby',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>