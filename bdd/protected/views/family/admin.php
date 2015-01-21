<h2>Managing families</h2>

<div class="actionBar">
[<?php echo CHtml::link('families List',array('list')); ?>]
[<?php echo CHtml::link('New families',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idfamily'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($familiesList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idfamily,array('show','id'=>$model->idfamily)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idfamily)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idfamily),
      	  'confirm'=>"Are you sure to delete #{$model->idfamily}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>