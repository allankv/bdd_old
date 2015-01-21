<h2>Managing audiences</h2>

<div class="actionBar">
[<?php echo CHtml::link('audiences List',array('list')); ?>]
[<?php echo CHtml::link('New audiences',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idaudiences'); ?></th>
    <th><?php echo $sort->link('audience'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idaudiences,array('show','id'=>$model->idaudiences)); ?></td>
    <td><?php echo CHtml::encode($model->audience); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idaudiences)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idaudiences),
      	  'confirm'=>"Are you sure to delete #{$model->idaudiences}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>