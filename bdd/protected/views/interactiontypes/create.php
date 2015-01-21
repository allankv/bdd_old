<h2>New interactiontypes</h2>

<div class="actionBar">
[<?php echo CHtml::link('interactiontypes List',array('list')); ?>]
[<?php echo CHtml::link('Manage interactiontypes',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'interactiontypes'=>$interactiontypes,
	'update'=>false,
)); ?>