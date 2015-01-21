<h2>Managing canonicalauthorship</h2>

<div class="actionBar">
[<?php echo CHtml::link('canonicalauthorship List',array('list')); ?>]
[<?php echo CHtml::link('New canonicalauthorship',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idcanonicalauthorship'); ?></th>
    <th><?php echo $sort->link('canonicalauthorship'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idcanonicalauthorship,array('show','id'=>$model->idcanonicalauthorship)); ?></td>
    <td><?php echo CHtml::encode($model->canonicalauthorship); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idcanonicalauthorship)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idcanonicalauthorship),
      	  'confirm'=>"Are you sure to delete #{$model->idcanonicalauthorship}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>