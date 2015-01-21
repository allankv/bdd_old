<h2>Update biologicalelements <?php echo $biologicalelements->idbiologicalelements; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('biologicalelements List',array('list')); ?>]
[<?php echo CHtml::link('New biologicalelements',array('create')); ?>]
[<?php echo CHtml::link('Manage biologicalelements',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'biologicalelements'=>$biologicalelements,
	'update'=>true,
	'showActionButton'=>true,
)); ?>