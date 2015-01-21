<h2>View users <?php echo $users->idUser; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('users List',array('list')); ?>]
[<?php echo CHtml::link('New users',array('create')); ?>]
[<?php echo CHtml::link('Update users',array('update','id'=>$users->idUser)); ?>]
[<?php echo CHtml::linkButton('Delete users',array('submit'=>array('delete','id'=>$users->idUser),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage users',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($users->getAttributeLabel('idGroup')); ?>
</th>
    <td><?php echo CHtml::encode($users->idGroup); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($users->getAttributeLabel('username')); ?>
</th>
    <td><?php echo CHtml::encode($users->username); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($users->getAttributeLabel('password')); ?>
</th>
    <td><?php echo CHtml::encode($users->password); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($users->getAttributeLabel('email')); ?>
</th>
    <td><?php echo CHtml::encode($users->email); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($users->getAttributeLabel('idUserAdd')); ?>
</th>
    <td><?php echo CHtml::encode($users->idUserAdd); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($users->getAttributeLabel('dateValidated')); ?>
</th>
    <td><?php echo CHtml::encode($users->dateValidated); ?>
</td>
</tr>
</table>
