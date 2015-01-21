<h2>View authoryearofscientificnames <?php echo $authoryearofscientificnames->idauthoryearofscientificname; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('authoryearofscientificnames List',array('list')); ?>]
[<?php echo CHtml::link('New authoryearofscientificnames',array('create')); ?>]
[<?php echo CHtml::link('Update authoryearofscientificnames',array('update','id'=>$authoryearofscientificnames->idauthoryearofscientificname)); ?>]
[<?php echo CHtml::linkButton('Delete authoryearofscientificnames',array('submit'=>array('delete','id'=>$authoryearofscientificnames->idauthoryearofscientificname),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage authoryearofscientificnames',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($authoryearofscientificnames->getAttributeLabel('authoryearofscientificname')); ?>
</th>
    <td><?php echo CHtml::encode($authoryearofscientificnames->authoryearofscientificname); ?>
</td>
</tr>
</table>
