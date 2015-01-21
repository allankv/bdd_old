<h2>View scientificnames <?php echo $scientificnames->idscientificname; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('scientificnames List',array('list')); ?>]
[<?php echo CHtml::link('New scientificnames',array('create')); ?>]
[<?php echo CHtml::link('Update scientificnames',array('update','id'=>$scientificnames->idscientificname)); ?>]
[<?php echo CHtml::linkButton('Delete scientificnames',array('submit'=>array('delete','id'=>$scientificnames->idscientificname),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage scientificnames',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($scientificnames->getAttributeLabel('scientificname')); ?>
</th>
    <td><?php echo CHtml::encode($scientificnames->scientificname); ?>
</td>
</tr>
</table>
