<h2>Update continents <?php echo $continents->idcontinent; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('continents List',array('list')); ?>]
[<?php echo CHtml::link('New continents',array('create')); ?>]
[<?php echo CHtml::link('Manage continents',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'continents'=>$continents,
	'update'=>true,
)); ?>