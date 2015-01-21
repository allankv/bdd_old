<h2>Managing scientificnames</h2>

<div class="actionBar">
[<?php echo CHtml::link('scientificnames List',array('list')); ?>]
[<?php echo CHtml::link('New scientificnames',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idscientificname'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($scientificnamesList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idscientificname,array('show','id'=>$model->idscientificname)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idscientificname)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idscientificname),
      	  'confirm'=>"Are you sure to delete #{$model->idscientificname}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>