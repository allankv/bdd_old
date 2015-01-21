<h2>attributes List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New attributes',array('create')); ?>]
[<?php echo CHtml::link('Manage attributes',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($attributesList as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idAttribute')); ?>:
<?php echo CHtml::link($model->idAttribute,array('show','id'=>$model->idAttribute)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('attribute')); ?>:
<?php echo CHtml::encode($model->attribute); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('description')); ?>:
<?php echo CHtml::encode($model->description); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>