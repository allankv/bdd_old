<h2>Managing acceptednameusage</h2>

<div class="actionBar">
[<?php echo CHtml::link('acceptednameusage List',array('list')); ?>]
[<?php echo CHtml::link('New acceptednameusage',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idacceptednameusage'); ?></th>
    <th><?php echo $sort->link('acceptednameusage'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idacceptednameusage,array('show','id'=>$model->idacceptednameusage)); ?></td>
    <td><?php echo CHtml::encode($model->acceptednameusage); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idacceptednameusage)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idacceptednameusage),
      	  'confirm'=>"Are you sure to delete #{$model->idacceptednameusage}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>