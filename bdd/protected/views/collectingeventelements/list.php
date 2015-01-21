<h2>collectingeventelements List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New collectingeventelements',array('create')); ?>]
[<?php echo CHtml::link('Manage collectingeventelements',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($collectingeventelementsList as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('idcollectingeventelements')); ?>:
<?php echo CHtml::link($model->idcollectingeventelements,array('show','id'=>$model->idcollectingeventelements)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idcollectingmethod')); ?>:
<?php echo CHtml::encode($model->idcollectingmethod); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idvaliddistributionflag')); ?>:
<?php echo CHtml::encode($model->idvaliddistributionflag); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('earliestdatecollected')); ?>:
<?php echo CHtml::encode($model->earliestdatecollected); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('latestdatecollected')); ?>:
<?php echo CHtml::encode($model->latestdatecollected); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('dayofyear')); ?>:
<?php echo CHtml::encode($model->dayofyear); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('idcollector')); ?>:
<?php echo CHtml::encode($model->idcollector); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>