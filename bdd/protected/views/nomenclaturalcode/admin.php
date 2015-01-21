<h2>Managing nomenclaturalcodes</h2>

<div class="actionBar">
[<?php echo CHtml::link('nomenclaturalcodes List',array('list')); ?>]
[<?php echo CHtml::link('New nomenclaturalcodes',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idnomenclaturalcode'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($nomenclaturalcodesList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idnomenclaturalcode,array('show','id'=>$model->idnomenclaturalcode)); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idnomenclaturalcode)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idnomenclaturalcode),
      	  'confirm'=>"Are you sure to delete #{$model->idnomenclaturalcode}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>