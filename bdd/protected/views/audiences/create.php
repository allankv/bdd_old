<h2>New audiences</h2>

<div class="actionBar">
[<?php echo CHtml::link('audiences List',array('list')); ?>]
[<?php echo CHtml::link('Manage audiences',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>