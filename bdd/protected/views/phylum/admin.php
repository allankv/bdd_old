<h2>Managing phylums</h2>

<div class="actionBar">
[<?php echo CHtml::link('phylums List',array('list')); ?>]
[<?php echo CHtml::link('New phylums',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idphylum'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($phylumsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idphylum,array('show','id'=>$model->idphylum)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idphylum)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idphylum),
      	  'confirm'=>"Are you sure to delete #{$model->idphylum}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>