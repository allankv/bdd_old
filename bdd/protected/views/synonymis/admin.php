<h2>Managing synonymis</h2>

<div class="actionBar">
[<?php echo CHtml::link('synonymis List',array('list')); ?>]
[<?php echo CHtml::link('New synonymis',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idsynonyms'); ?></th>
    <th><?php echo $sort->link('synonyms'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idsynonyms,array('show','id'=>$model->idsynonyms)); ?></td>
    <td><?php echo CHtml::encode($model->synonyms); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idsynonyms)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idsynonyms),
      	  'confirm'=>"Are you sure to delete #{$model->idsynonyms}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>