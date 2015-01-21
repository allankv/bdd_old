<h2>Update institutioncodes <?php echo $institutioncodes->idinstitutioncode; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('institutioncodes List',array('list')); ?>]
[<?php echo CHtml::link('New institutioncodes',array('create')); ?>]
[<?php echo CHtml::link('Manage institutioncodes',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'institutioncodes'=>$institutioncodes,
	'update'=>true,
)); ?>