<h2>Managing contributors</h2>

<div class="actionBar">
[<?php echo CHtml::link('contributors List',array('list')); ?>]
[<?php echo CHtml::link('New contributors',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idcontributors'); ?></th>
    <th><?php echo $sort->link('contributor'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idcontributors,array('show','id'=>$model->idcontributors)); ?></td>
    <td><?php echo CHtml::encode($model->contributor); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idcontributors)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idcontributors),
      	  'confirm'=>"Are you sure to delete #{$model->idcontributors}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>