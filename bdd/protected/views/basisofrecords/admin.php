<h2>Managing basisofrecords</h2>

<div class="actionBar">
[<?php echo CHtml::link('basisofrecords List',array('list')); ?>]
[<?php echo CHtml::link('New basisofrecords',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idbasisofrecord'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($basisofrecordsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idbasisofrecord,array('show','id'=>$model->idbasisofrecord)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idbasisofrecord)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idbasisofrecord),
      	  'confirm'=>"Are you sure to delete #{$model->idbasisofrecord}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>