<h2>Managing reproductions</h2>

<div class="actionBar">
[<?php echo CHtml::link('reproductions List',array('list')); ?>]
[<?php echo CHtml::link('New reproductions',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idreproduction'); ?></th>
    <th><?php echo $sort->link('reproductions'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idreproduction,array('show','id'=>$model->idreproduction)); ?></td>
    <td><?php echo CHtml::encode($model->reproductions); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idreproduction)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idreproduction),
      	  'confirm'=>"Are you sure to delete #{$model->idreproduction}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>