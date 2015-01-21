<h2>New collectingeventelements</h2>

<div class="actionBar">
[<?php echo CHtml::link('collectingeventelements List',array('list')); ?>]
[<?php echo CHtml::link('Manage collectingeventelements',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'collectingeventelements'=>$collectingeventelements,
	'update'=>false,
)); ?>