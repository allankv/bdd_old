<h2>Update othercatalognumbers <?php echo $model->idothercatalognumbers; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('othercatalognumbers List',array('list')); ?>]
[<?php echo CHtml::link('New othercatalognumbers',array('create')); ?>]
[<?php echo CHtml::link('Manage othercatalognumbers',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>