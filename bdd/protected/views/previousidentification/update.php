<h2>Update previousidentification <?php echo $model->idpreviousidentification; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('previousidentification List',array('list')); ?>]
[<?php echo CHtml::link('New previousidentification',array('create')); ?>]
[<?php echo CHtml::link('Manage previousidentification',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>