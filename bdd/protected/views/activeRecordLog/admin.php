<h2>Managing ActiveRecordLog</h2>

<div class="actionBar">
[<?php echo CHtml::link('ActiveRecordLog List',array('list')); ?>]
[<?php echo CHtml::link('New ActiveRecordLog',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('id'); ?></th>
    <th><?php echo $sort->link('description'); ?></th>
    <th><?php echo $sort->link('action'); ?></th>
    <th><?php echo $sort->link('model'); ?></th>
    <th><?php echo $sort->link('idModel'); ?></th>
    <th><?php echo $sort->link('field'); ?></th>
    <th><?php echo $sort->link('creationdate'); ?></th>
    <th><?php echo $sort->link('userid'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($activerecordlogList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?></td>
    <td><?php echo CHtml::encode($model->description); ?></td>
    <td><?php echo CHtml::encode($model->action); ?></td>
    <td><?php echo CHtml::encode($model->model); ?></td>
    <td><?php echo CHtml::encode($model->idModel); ?></td>
    <td><?php echo CHtml::encode($model->field); ?></td>
    <td><?php echo CHtml::encode($model->creationdate); ?></td>
    <td><?php echo CHtml::encode($model->userid); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->id)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->id),
      	  'confirm'=>"Are you sure to delete #{$model->id}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>