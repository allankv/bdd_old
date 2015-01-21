<h2>Update basisofrecords <?php echo $basisofrecords->idbasisofrecord; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('basisofrecords List',array('list')); ?>]
[<?php echo CHtml::link('New basisofrecords',array('create')); ?>]
[<?php echo CHtml::link('Manage basisofrecords',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'basisofrecords'=>$basisofrecords,
	'update'=>true,
)); ?>