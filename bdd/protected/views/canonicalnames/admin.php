<h2>Managing canonicalnames</h2>

<div class="actionBar">
[<?php echo CHtml::link('canonicalnames List',array('list')); ?>]
[<?php echo CHtml::link('New canonicalnames',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idcanonicalnames'); ?></th>
    <th><?php echo $sort->link('idcanonicalauthorship'); ?></th>
    <th><?php echo $sort->link('canonicalname'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idcanonicalnames,array('show','id'=>$model->idcanonicalnames)); ?></td>
    <td><?php echo CHtml::encode($model->idcanonicalauthorship); ?></td>
    <td><?php echo CHtml::encode($model->canonicalname); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idcanonicalnames)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idcanonicalnames),
      	  'confirm'=>"Are you sure to delete #{$model->idcanonicalnames}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>