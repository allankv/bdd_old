<h2>Update subjectcategory <?php echo $model->idsubjectcategory; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('subjectcategory List',array('list')); ?>]
[<?php echo CHtml::link('New subjectcategory',array('create')); ?>]
[<?php echo CHtml::link('Manage subjectcategory',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>