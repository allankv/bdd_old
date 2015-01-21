<h2>View classes <?php echo $classes->idclass; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('classes List',array('list')); ?>]
[<?php echo CHtml::link('New classes',array('create')); ?>]
[<?php echo CHtml::link('Update classes',array('update','id'=>$classes->idclass)); ?>]
[<?php echo CHtml::linkButton('Delete classes',array('submit'=>array('delete','id'=>$classes->idclass),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage classes',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($classes->getAttributeLabel('class')); ?>
</th>
    <td><?php echo CHtml::encode($classes->class); ?>
</td>
</tr>
</table>
