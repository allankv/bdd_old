<h2>Managing georeferedby</h2>

<div class="actionBar">
[<?php echo CHtml::link('georeferedby List',array('list')); ?>]
[<?php echo CHtml::link('New georeferedby',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idgeoreferdby'); ?></th>
    <th><?php echo $sort->link('georeferdedby'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idgeoreferdby,array('show','id'=>$model->idgeoreferdby)); ?></td>
    <td><?php echo CHtml::encode($model->georeferdedby); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idgeoreferdby)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idgeoreferdby),
      	  'confirm'=>"Are you sure to delete #{$model->idgeoreferdby}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>