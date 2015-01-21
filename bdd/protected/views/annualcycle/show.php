<h2>View annualcycle <?php echo $model->idannualcycle; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('annualcycle List',array('list')); ?>]
[<?php echo CHtml::link('New annualcycle',array('create')); ?>]
[<?php echo CHtml::link('Update annualcycle',array('update','id'=>$model->idannualcycle)); ?>]
[<?php echo CHtml::linkButton('Delete annualcycle',array('submit'=>array('delete','id'=>$model->idannualcycle),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage annualcycle',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('annualcycle')); ?>
</th>
    <td><?php echo CHtml::encode($model->annualcycle); ?>
</td>
</tr>
</table>
