<h2>Update associatedmedia <?php echo $model->idassociatedmedia; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('associatedmedia List',array('list')); ?>]
[<?php echo CHtml::link('New associatedmedia',array('create')); ?>]
[<?php echo CHtml::link('Manage associatedmedia',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>