<h2>View scientificnameauthorships <?php echo $scientificnameauthorships->idscientificnameauthorship; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('scientificnameauthorships List',array('list')); ?>]
[<?php echo CHtml::link('New scientificnameauthorships',array('create')); ?>]
[<?php echo CHtml::link('Update scientificnameauthorships',array('update','id'=>$scientificnameauthorships->idscientificnameauthorship)); ?>]
[<?php echo CHtml::linkButton('Delete scientificnameauthorships',array('submit'=>array('delete','id'=>$scientificnameauthorships->idscientificnameauthorship),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage scientificnameauthorships',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($scientificnameauthorships->getAttributeLabel('scientificnameauthorship')); ?>
</th>
    <td><?php echo CHtml::encode($scientificnameauthorships->scientificnameauthorship); ?>
</td>
</tr>
</table>
