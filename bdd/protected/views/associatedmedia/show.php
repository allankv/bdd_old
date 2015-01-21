<h2>View associatedmedia <?php echo $model->idassociatedmedia; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('associatedmedia List',array('list')); ?>]
[<?php echo CHtml::link('New associatedmedia',array('create')); ?>]
[<?php echo CHtml::link('Update associatedmedia',array('update','id'=>$model->idassociatedmedia)); ?>]
[<?php echo CHtml::linkButton('Delete associatedmedia',array('submit'=>array('delete','id'=>$model->idassociatedmedia),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage associatedmedia',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('associatedmedia')); ?>
</th>
    <td><?php echo CHtml::encode($model->associatedmedia); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('idrecordlevelelements')); ?>
</th>
    <td><?php echo CHtml::encode($model->idrecordlevelelements); ?>
</td>
</tr>
</table>
