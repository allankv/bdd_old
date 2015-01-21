<h2>Managing collectingeventelements</h2>

<div class="actionBar">
[<?php echo CHtml::link('collectingeventelements List',array('list')); ?>]
[<?php echo CHtml::link('New collectingeventelements',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idcollectingeventelements'); ?></th>
    <th><?php echo $sort->link('idcollectingmethod'); ?></th>
    <th><?php echo $sort->link('idvaliddistributionflag'); ?></th>
    <th><?php echo $sort->link('earliestdatecollected'); ?></th>
    <th><?php echo $sort->link('latestdatecollected'); ?></th>
    <th><?php echo $sort->link('dayofyear'); ?></th>
    <th><?php echo $sort->link('idcollector'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($collectingeventelementsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idcollectingeventelements,array('show','id'=>$model->idcollectingeventelements)); ?></td>
    <td><?php echo CHtml::encode($model->idcollectingmethod); ?></td>
    <td><?php echo CHtml::encode($model->idvaliddistributionflag); ?></td>
    <td><?php echo CHtml::encode($model->earliestdatecollected); ?></td>
    <td><?php echo CHtml::encode($model->latestdatecollected); ?></td>
    <td><?php echo CHtml::encode($model->dayofyear); ?></td>
    <td><?php echo CHtml::encode($model->idcollector); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idcollectingeventelements)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idcollectingeventelements),
      	  'confirm'=>"Are you sure to delete #{$model->idcollectingeventelements}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>