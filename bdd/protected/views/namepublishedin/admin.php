<h2>Managing namepublishedin</h2>

<div class="actionBar">
[<?php echo CHtml::link('namepublishedin List',array('list')); ?>]
[<?php echo CHtml::link('New namepublishedin',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idnamepublishedin'); ?></th>
    <th><?php echo $sort->link('namepublishedin'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idnamepublishedin,array('show','id'=>$model->idnamepublishedin)); ?></td>
    <td><?php echo CHtml::encode($model->namepublishedin); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idnamepublishedin)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idnamepublishedin),
      	  'confirm'=>"Are you sure to delete #{$model->idnamepublishedin}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>