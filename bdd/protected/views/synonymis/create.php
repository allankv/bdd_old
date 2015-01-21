<h2>New synonymis</h2>

<div class="actionBar">
[<?php echo CHtml::link('synonymis List',array('list')); ?>]
[<?php echo CHtml::link('Manage synonymis',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>