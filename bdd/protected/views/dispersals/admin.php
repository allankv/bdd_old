<h2>Managing dispersals</h2>

<div class="actionBar">
[<?php echo CHtml::link('dispersals List',array('list')); ?>]
[<?php echo CHtml::link('New dispersals',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('iddispersal'); ?></th>
    <th><?php echo $sort->link('dispersal'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->iddispersal,array('show','id'=>$model->iddispersal)); ?></td>
    <td><?php echo CHtml::encode($model->dispersal); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->iddispersal)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->iddispersal),
      	  'confirm'=>"Are you sure to delete #{$model->iddispersal}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>