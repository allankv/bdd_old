<h2>Managing validdistributionflags</h2>

<div class="actionBar">
[<?php echo CHtml::link('validdistributionflags List',array('list')); ?>]
[<?php echo CHtml::link('New validdistributionflags',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idvaliddistributionflag'); ?></th>
    <th><?php echo $sort->link('validdistributionflag'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($validdistributionflagsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idvaliddistributionflag,array('show','id'=>$model->idvaliddistributionflag)); ?></td>
    <td><?php echo CHtml::encode($model->validdistributionflag); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idvaliddistributionflag)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idvaliddistributionflag),
      	  'confirm'=>"Are you sure to delete #{$model->idvaliddistributionflag}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>