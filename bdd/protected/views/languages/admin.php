<h2>Managing languages</h2>

<div class="actionBar">
[<?php echo CHtml::link('languages List',array('list')); ?>]
[<?php echo CHtml::link('New languages',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idlanguages'); ?></th>
    <th><?php echo $sort->link('language'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idlanguages,array('show','id'=>$model->idlanguages)); ?></td>
    <td><?php echo CHtml::encode($model->language); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idlanguages)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idlanguages),
      	  'confirm'=>"Are you sure to delete #{$model->idlanguages}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>