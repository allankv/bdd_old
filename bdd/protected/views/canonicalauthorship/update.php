<h2>Update canonicalauthorship <?php echo $model->idcanonicalauthorship; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('canonicalauthorship List',array('list')); ?>]
[<?php echo CHtml::link('New canonicalauthorship',array('create')); ?>]
[<?php echo CHtml::link('Manage canonicalauthorship',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>