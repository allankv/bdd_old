<h2>Managing scientificnameauthorships</h2>

<div class="actionBar">
[<?php echo CHtml::link('scientificnameauthorships List',array('list')); ?>]
[<?php echo CHtml::link('New scientificnameauthorships',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idscientificnameauthorship'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($scientificnameauthorshipsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idscientificnameauthorship,array('show','id'=>$model->idscientificnameauthorship)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idscientificnameauthorship)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idscientificnameauthorship),
      	  'confirm'=>"Are you sure to delete #{$model->idscientificnameauthorship}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>