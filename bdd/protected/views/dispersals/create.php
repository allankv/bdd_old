<h2>New dispersals</h2>

<div class="actionBar">
[<?php echo CHtml::link('dispersals List',array('list')); ?>]
[<?php echo CHtml::link('Manage dispersals',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>