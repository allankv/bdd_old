<h2>Update occurrenceelements <?php echo $model->idoccurrenceelements; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('occurrenceelements List',array('list')); ?>]
[<?php echo CHtml::link('New occurrenceelements',array('create')); ?>]
[<?php echo CHtml::link('Manage occurrenceelements',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>