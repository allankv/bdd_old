<h2>Managing migrations</h2>

<div class="actionBar">
[<?php echo CHtml::link('migrations List',array('list')); ?>]
[<?php echo CHtml::link('New migrations',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idmigration'); ?></th>
    <th><?php echo $sort->link('migration'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idmigration,array('show','id'=>$model->idmigration)); ?></td>
    <td><?php echo CHtml::encode($model->migration); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idmigration)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idmigration),
      	  'confirm'=>"Are you sure to delete #{$model->idmigration}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>