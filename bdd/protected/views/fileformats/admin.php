<h2>Managing fileformats</h2>

<div class="actionBar">
[<?php echo CHtml::link('fileformats List',array('list')); ?>]
[<?php echo CHtml::link('New fileformats',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idfileformats'); ?></th>
    <th><?php echo $sort->link('fileformat'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idfileformats,array('show','id'=>$model->idfileformats)); ?></td>
    <td><?php echo CHtml::encode($model->fileformat); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idfileformats)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idfileformats),
      	  'confirm'=>"Are you sure to delete #{$model->idfileformats}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>