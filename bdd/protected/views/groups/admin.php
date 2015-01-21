<h2>Managing groups</h2>

<div class="actionBar">
[<?php echo CHtml::link('groups List',array('list')); ?>]
[<?php echo CHtml::link('New groups',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idGroup'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($groupsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idGroup,array('show','id'=>$model->idGroup)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idGroup)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idGroup),
      	  'confirm'=>"Are you sure to delete #{$model->idGroup}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>