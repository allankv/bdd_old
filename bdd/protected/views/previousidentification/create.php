<h2>New previousidentification</h2>

<div class="actionBar">
[<?php echo CHtml::link('previousidentification List',array('list')); ?>]
[<?php echo CHtml::link('Manage previousidentification',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>