<h2>Update dispersals <?php echo $model->iddispersal; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('dispersals List',array('list')); ?>]
[<?php echo CHtml::link('New dispersals',array('create')); ?>]
[<?php echo CHtml::link('Manage dispersals',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>