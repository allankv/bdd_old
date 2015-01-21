<h2>Update interactiontypes <?php echo $interactiontypes->idinteractiontype; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('interactiontypes List',array('list')); ?>]
[<?php echo CHtml::link('New interactiontypes',array('create')); ?>]
[<?php echo CHtml::link('Manage interactiontypes',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'interactiontypes'=>$interactiontypes,
	'update'=>true,
)); ?>