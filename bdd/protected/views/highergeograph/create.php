<h2>New highergeograph</h2>

<div class="actionBar">
[<?php echo CHtml::link('highergeograph List',array('list')); ?>]
[<?php echo CHtml::link('Manage highergeograph',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>