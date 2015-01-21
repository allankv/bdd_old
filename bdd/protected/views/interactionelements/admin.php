<h2>Managing interactionelements</h2>

<div class="actionBar">
[<?php echo CHtml::link('interactionelements List',array('list')); ?>]
[<?php echo CHtml::link('New interactionelements',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idinteractionelements'); ?></th>
    <th><?php echo $sort->link('idspecimens1'); ?></th>
    <th><?php echo $sort->link('idspecimens2'); ?></th>
    <th><?php echo $sort->link('idinteractiontype'); ?></th>
    <th><?php echo $sort->link('modified'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($interactionelementsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idinteractionelements,array('show','id'=>$model->idinteractionelements)); ?></td>
    <td><?php echo CHtml::encode($model->idspecimens1); ?></td>
    <td><?php echo CHtml::encode($model->idspecimens2); ?></td>
    <td><?php echo CHtml::encode($model->idinteractiontype); ?></td>
    <td><?php echo CHtml::encode($model->modified); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idinteractionelements)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idinteractionelements),
      	  'confirm'=>"Are you sure to delete #{$model->idinteractionelements}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>