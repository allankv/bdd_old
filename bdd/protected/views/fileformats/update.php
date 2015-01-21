<h2>Update fileformats <?php echo $model->idfileformats; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('fileformats List',array('list')); ?>]
[<?php echo CHtml::link('New fileformats',array('create')); ?>]
[<?php echo CHtml::link('Manage fileformats',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>