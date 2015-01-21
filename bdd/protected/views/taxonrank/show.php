<h2>View taxonrank <?php echo $taxonrank->idinfraspecificrank; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('taxonrank List',array('list')); ?>]
[<?php echo CHtml::link('New taxonrank',array('create')); ?>]
[<?php echo CHtml::link('Update taxonrank',array('update','id'=>$taxonranks->idinfraspecificrank)); ?>]
[<?php echo CHtml::linkButton('Delete taxonrank',array('submit'=>array('delete','id'=>$taxonranks->idinfraspecificrank),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage taxonrank',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($taxonranks->getAttributeLabel('infraspecificrank')); ?>
</th>
    <td><?php echo CHtml::encode($taxonranks->infraspecificrank); ?>
</td>
</tr>
</table>
