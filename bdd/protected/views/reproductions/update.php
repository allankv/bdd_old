<h2>Update reproductions <?php echo $model->idreproduction; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('reproductions List',array('list')); ?>]
[<?php echo CHtml::link('New reproductions',array('create')); ?>]
[<?php echo CHtml::link('Manage reproductions',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>