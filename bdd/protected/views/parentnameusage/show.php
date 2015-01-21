<h2>View parentnameusage <?php echo $model->idparentnameusage; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('parentnameusage List',array('list')); ?>]
[<?php echo CHtml::link('New parentnameusage',array('create')); ?>]
[<?php echo CHtml::link('Update parentnameusage',array('update','id'=>$model->idparentnameusage)); ?>]
[<?php echo CHtml::linkButton('Delete parentnameusage',array('submit'=>array('delete','id'=>$model->idparentnameusage),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage parentnameusage',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('parentnameusage')); ?>
</th>
    <td><?php echo CHtml::encode($model->parentnameusage); ?>
</td>
</tr>
</table>
