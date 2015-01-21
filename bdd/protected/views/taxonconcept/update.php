<h2>Update taxonconcept <?php echo $model->idtaxonconcept; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('taxonconcept List',array('list')); ?>]
[<?php echo CHtml::link('New taxonconcept',array('create')); ?>]
[<?php echo CHtml::link('Manage taxonconcept',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>