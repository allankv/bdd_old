<h2>Managing publishers</h2>

<div class="actionBar">
[<?php echo CHtml::link('publishers List',array('list')); ?>]
[<?php echo CHtml::link('New publishers',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idpublishers'); ?></th>
    <th><?php echo $sort->link('publisher'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idpublishers,array('show','id'=>$model->idpublishers)); ?></td>
    <td><?php echo CHtml::encode($model->publisher); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idpublishers)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idpublishers),
      	  'confirm'=>"Are you sure to delete #{$model->idpublishers}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>