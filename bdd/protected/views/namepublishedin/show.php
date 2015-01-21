<h2>View namepublishedin <?php echo $model->idnamepublishedin; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('namepublishedin List',array('list')); ?>]
[<?php echo CHtml::link('New namepublishedin',array('create')); ?>]
[<?php echo CHtml::link('Update namepublishedin',array('update','id'=>$model->idnamepublishedin)); ?>]
[<?php echo CHtml::linkButton('Delete namepublishedin',array('submit'=>array('delete','id'=>$model->idnamepublishedin),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage namepublishedin',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('namepublishedin')); ?>
</th>
    <td><?php echo CHtml::encode($model->namepublishedin); ?>
</td>
</tr>
</table>
