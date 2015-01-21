<h2>View basisofrecords <?php echo $basisofrecords->idbasisofrecord; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('basisofrecords List',array('list')); ?>]
[<?php echo CHtml::link('New basisofrecords',array('create')); ?>]
[<?php echo CHtml::link('Update basisofrecords',array('update','id'=>$basisofrecords->idbasisofrecord)); ?>]
[<?php echo CHtml::linkButton('Delete basisofrecords',array('submit'=>array('delete','id'=>$basisofrecords->idbasisofrecord),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage basisofrecords',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($basisofrecords->getAttributeLabel('basisofrecord')); ?>
</th>
    <td><?php echo CHtml::encode($basisofrecords->basisofrecord); ?>
</td>
</tr>
</table>
