<h2>Managing users</h2>

<div class="actionBar">
[<?php echo CHtml::link('users List',array('list')); ?>]
[<?php echo CHtml::link('New users',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idUser'); ?></th>
    <th><?php echo $sort->link('idGroup'); ?></th>
    <th><?php echo $sort->link('username'); ?></th>
    <th><?php echo $sort->link('idUserAdd'); ?></th>
    <th><?php echo $sort->link('dateValidated'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($usersList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idUser,array('show','id'=>$model->idUser)); ?></td>
    <td><?php echo CHtml::encode($model->idGroup); ?></td>
    <td><?php echo CHtml::encode($model->username); ?></td>
    <td><?php echo CHtml::encode($model->idUserAdd); ?></td>
    <td><?php echo CHtml::encode($model->dateValidated); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idUser)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idUser),
      	  'confirm'=>"Are you sure to delete #{$model->idUser}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>