<h2>New subjectcategory</h2>

<div class="actionBar">
[<?php echo CHtml::link('subjectcategory List',array('list')); ?>]
[<?php echo CHtml::link('Manage subjectcategory',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>