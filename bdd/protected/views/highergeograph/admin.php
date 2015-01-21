<h2>Managing highergeograph</h2>

<div class="actionBar">
[<?php echo CHtml::link('highergeograph List',array('list')); ?>]
[<?php echo CHtml::link('New highergeograph',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idhighergeograph'); ?></th>
    <th><?php echo $sort->link('highergeographid'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idhighergeograph,array('show','id'=>$model->idhighergeograph)); ?></td>
    <td><?php echo CHtml::encode($model->highergeographid); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idhighergeograph)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idhighergeograph),
      	  'confirm'=>"Are you sure to delete #{$model->idhighergeograph}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>