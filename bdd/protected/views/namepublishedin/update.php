<h2>Update namepublishedin <?php echo $model->idnamepublishedin; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('namepublishedin List',array('list')); ?>]
[<?php echo CHtml::link('New namepublishedin',array('create')); ?>]
[<?php echo CHtml::link('Manage namepublishedin',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>