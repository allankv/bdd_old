<h2>Managing recordlevelelements</h2>

<div class="actionBar">
[<?php echo CHtml::link('recordlevelelements List',array('list')); ?>]
[<?php echo CHtml::link('New recordlevelelements',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('idrecordlevelelements'); ?></th>
    <th><?php echo $sort->link('datelastmodified'); ?></th>
    <th><?php echo $sort->link('idinstitutioncode'); ?></th>
    <th><?php echo $sort->link('idcollectioncode'); ?></th>
    <th><?php echo $sort->link('idbasisofrecord'); ?></th>
    <th><?php echo $sort->link('idcollecting'); ?></th>
    <th><?php echo $sort->link('idoccurrenceelements'); ?></th>
    <th><?php echo $sort->link('idtaxonomicelements'); ?></th>
    <th><?php echo $sort->link('idcuratorialelements'); ?></th>
    <th><?php echo $sort->link('ididentificationelements'); ?></th>
    <th><?php echo $sort->link('idlocalityelements'); ?></th>
    <th><?php echo $sort->link('idreferenceselements'); ?></th>
    <th><?php echo $sort->link('idgeospatialelements'); ?></th>
    <th><?php echo $sort->link('idupload'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($recordlevelelementsList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->idrecordlevelelements,array('show','id'=>$model->idrecordlevelelements)); ?></td>
    <td><?php echo CHtml::encode($model->datelastmodified); ?></td>
    <td><?php echo CHtml::encode($model->idinstitutioncode); ?></td>
    <td><?php echo CHtml::encode($model->idcollectioncode); ?></td>
    <td><?php echo CHtml::encode($model->idbasisofrecord); ?></td>
    <td><?php echo CHtml::encode($model->idcollecting); ?></td>
    <td><?php echo CHtml::encode($model->idoccurrenceelements); ?></td>
    <td><?php echo CHtml::encode($model->idcuratorialelements); ?></td>
    <td><?php echo CHtml::encode($model->idtaxonomicelements); ?></td>
    <td><?php echo CHtml::encode($model->ididentificationelements); ?></td>
    <td><?php echo CHtml::encode($model->idlocalityelements); ?></td>
    
    <td><?php echo CHtml::encode($model->idreferenceselements); ?></td>
    <td><?php echo CHtml::encode($model->idgeospatialelements); ?></td>
    <td><?php echo CHtml::encode($model->idupload); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->idrecordlevelelements)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->idrecordlevelelements),
      	  'confirm'=>"Are you sure to delete #{$model->idrecordlevelelements}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>