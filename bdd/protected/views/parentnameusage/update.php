<h2>Update parentnameusage <?php echo $model->idparentnameusage; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('parentnameusage List',array('list')); ?>]
[<?php echo CHtml::link('New parentnameusage',array('create')); ?>]
[<?php echo CHtml::link('Manage parentnameusage',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>