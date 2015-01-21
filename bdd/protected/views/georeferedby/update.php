<h2>Update georeferedby <?php echo $model->idgeoreferdby; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('georeferedby List',array('list')); ?>]
[<?php echo CHtml::link('New georeferedby',array('create')); ?>]
[<?php echo CHtml::link('Manage georeferedby',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>