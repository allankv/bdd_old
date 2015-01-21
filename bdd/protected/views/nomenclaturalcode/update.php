<h2>Update nomenclaturalcodes <?php echo $nomenclaturalcodes->idnomenclaturalcode; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('nomenclaturalcodes List',array('list')); ?>]
[<?php echo CHtml::link('New nomenclaturalcodes',array('create')); ?>]
[<?php echo CHtml::link('Manage nomenclaturalcodes',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'nomenclaturalcodes'=>$nomenclaturalcodes,
	'update'=>true,
)); ?>