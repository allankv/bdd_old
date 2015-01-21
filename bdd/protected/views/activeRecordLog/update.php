<h2>Update ActiveRecordLog <?php echo $activerecordlog->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('ActiveRecordLog List',array('list')); ?>]
[<?php echo CHtml::link('New ActiveRecordLog',array('create')); ?>]
[<?php echo CHtml::link('Manage ActiveRecordLog',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'activerecordlog'=>$activerecordlog,
	'update'=>true,
)); ?>