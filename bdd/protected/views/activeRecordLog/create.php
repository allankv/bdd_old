<h2>New ActiveRecordLog</h2>

<div class="actionBar">
[<?php echo CHtml::link('ActiveRecordLog List',array('list')); ?>]
[<?php echo CHtml::link('Manage ActiveRecordLog',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'activerecordlog'=>$activerecordlog,
	'update'=>false,
)); ?>