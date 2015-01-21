<h2>Update nameaccordingto <?php echo $model->idnameaccordingto; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('nameaccordingto List',array('list')); ?>]
[<?php echo CHtml::link('New nameaccordingto',array('create')); ?>]
[<?php echo CHtml::link('Manage nameaccordingto',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>