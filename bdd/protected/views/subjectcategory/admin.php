<h2>Managing subjectcategory</h2>

<div class="actionBar">
[<?php echo CHtml::link('subjectcategory List',array('list')); ?>]
[<?php echo CHtml::link('New subjectcategory',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('idsubjectcategory'); ?></th>
    <th><?php echo $sort->link('subjectcategory'); ?></th>
    <th><?php echo $sort->link('idsubjectcategoryvocabulary'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idsubjectcategory,array('show','id'=>$model->idsubjectcategory)); ?></td>
    <td><?php echo CHtml::encode($model->subjectcategory); ?></td>
    <td><?php echo CHtml::encode($model->idsubjectcategoryvocabulary); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idsubjectcategory)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idsubjectcategory),
      	  'confirm'=>"Are you sure to delete #{$model->idsubjectcategory}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>