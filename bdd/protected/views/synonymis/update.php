<h2>Update synonymis <?php echo $model->idsynonyms; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('synonymis List',array('list')); ?>]
[<?php echo CHtml::link('New synonymis',array('create')); ?>]
[<?php echo CHtml::link('Manage synonymis',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>