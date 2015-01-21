<h2>New canonicalauthorship</h2>

<div class="actionBar">
[<?php echo CHtml::link('canonicalauthorship List',array('list')); ?>]
[<?php echo CHtml::link('Manage canonicalauthorship',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>