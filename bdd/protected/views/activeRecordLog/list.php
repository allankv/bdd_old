<h2>ActiveRecordLog List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New ActiveRecordLog',array('create')); ?>]
[<?php echo CHtml::link('Manage ActiveRecordLog',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($activerecordlogList as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:
<?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('description')); ?>:
<?php echo CHtml::encode($model->description); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('action')); ?>:
<?php echo CHtml::encode($model->action); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('model')); ?>:
<?php echo CHtml::encode($model->model); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idModel')); ?>:
<?php echo CHtml::encode($model->idModel); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('field')); ?>:
<?php echo CHtml::encode($model->field); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('creationdate')); ?>:
<?php echo CHtml::encode($model->creationdate); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('userid')); ?>:
<?php echo CHtml::encode($model->userid); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>