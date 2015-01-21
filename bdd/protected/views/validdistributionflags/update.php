<h2>Update validdistributionflags <?php echo $validdistributionflags->idvaliddistributionflag; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('validdistributionflags List',array('list')); ?>]
[<?php echo CHtml::link('New validdistributionflags',array('create')); ?>]
[<?php echo CHtml::link('Manage validdistributionflags',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'validdistributionflags'=>$validdistributionflags,
	'update'=>true,
)); ?>