<h2>View publishers <?php echo $model->idpublishers; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('publishers List',array('list')); ?>]
[<?php echo CHtml::link('New publishers',array('create')); ?>]
[<?php echo CHtml::link('Update publishers',array('update','id'=>$model->idpublishers)); ?>]
[<?php echo CHtml::linkButton('Delete publishers',array('submit'=>array('delete','id'=>$model->idpublishers),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage publishers',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('publisher')); ?>
</th>
    <td><?php echo CHtml::encode($model->publisher); ?>
</td>
</tr>
</table>
