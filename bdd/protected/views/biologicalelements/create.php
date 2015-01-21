<h2>New biologicalelements</h2>

<div class="actionBar">
[<?php echo CHtml::link('biologicalelements List',array('list')); ?>]
[<?php echo CHtml::link('Manage biologicalelements',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'biologicalelements'=>$biologicalelements,
	'update'=>false,
	'showActionButton'=>true,
)); ?>