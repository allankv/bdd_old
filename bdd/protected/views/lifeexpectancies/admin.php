<h2>Managing lifeexpectancies</h2>

<div class="actionBar">
[<?php echo CHtml::link('lifeexpectancies List',array('list')); ?>]
[<?php echo CHtml::link('New lifeexpectancies',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idlifeexpectancies'); ?></th>
    <th><?php echo $sort->link('lifeexpectancies'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idlifeexpectancies,array('show','id'=>$model->idlifeexpectancies)); ?></td>
    <td><?php echo CHtml::encode($model->lifeexpectancies); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idlifeexpectancies)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idlifeexpectancies),
      	  'confirm'=>"Are you sure to delete #{$model->idlifeexpectancies}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>